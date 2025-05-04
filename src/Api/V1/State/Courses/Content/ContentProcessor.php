<?php

namespace App\Api\V1\State\Courses\Content;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Api\V1\Mapper\Courses\Content\ContentMapper;
use App\Entity\Content;
use App\Entity\Translation;
use App\Repository\ChapterRepository;
use App\Repository\ContentRepository;
use App\Repository\ContentTypeRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ContentProcessor implements ProcessorInterface {

    private EntityManagerInterface $em;
    private ChapterRepository $chapterRepository;
    private ContentRepository $contentRepository;
    private ContentTypeRepository $contentTypeRepository;

    public function __construct(
        EntityManagerInterface $em,
        ChapterRepository $chapterRepository,
        ContentRepository $contentRepository,
        ContentTypeRepository $contentTypeRepository
    ) {
        $this->em = $em;
        $this->chapterRepository = $chapterRepository;
        $this->contentRepository = $contentRepository;
        $this->contentTypeRepository = $contentTypeRepository;
    }

    public function process(
        mixed $data,
        Operation $operation,
        array $uriVariables = [],
        array $context = []
    ) {

        /** @var \App\Entity\Chapter */
        $chapter = $this->chapterRepository->findOneBy([
            'id' => $data->chapter_id
        ]);

        if(!$chapter) {
            throw new NotFoundHttpException('Chapter not found');
        }

        /** @var \App\Entity\Content */
        $parentContent = $this->contentRepository->findOneBy([
            'chapter' => $chapter->getId(),
            'id' => $data->parent_id
        ]);

        /** @var \App\Entity\ContentType */
        $contentType = $this->contentTypeRepository->findOneBy([
            'id' => $data->content_type_id,
        ]);

        if(!$contentType) {
            throw new NotFoundHttpException('Content type not found');
        }

        /** @var \App\Entity\Content */
        $previousContent = $this->contentRepository->findOneBy([
            'chapter' => $chapter->getId(),
            'parentContent' => $parentContent?->getId(),
            'nextContent' => null
        ]);

        $content = new Content();
        $content
            ->setChapter($chapter)
            ->setType($contentType)
            ->setParentContent($parentContent)
            ->setPreviousContent($previousContent)
            ->setTranslation(new Translation())
            ->setCreatedAt(new DateTime())
            ->setUpdatedAt(new DateTime())
        ;

        if($previousContent) {
            $previousContent->setNextContent($content);
            $this->em->persist($previousContent);
        }

        $this->em->persist($content);
        $this->em->flush();

        return ContentMapper::fromEntity($content);
    }

}