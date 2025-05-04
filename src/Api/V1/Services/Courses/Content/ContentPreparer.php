<?php

namespace App\Api\V1\Services\Courses\Content;

use App\Api\V1\Dto\Courses\Content\PreparedContentInput;
use App\Api\V1\Services\PreparerInterface;
use App\Repository\ChapterRepository;
use App\Repository\ContentRepository;
use App\Repository\ContentTypeRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ContentPreparer implements PreparerInterface
{

    private ChapterRepository $chapterRepository;
    private ContentRepository $contentRepository;
    private ContentTypeRepository $contentTypeRepository;

    public function __construct(
        ChapterRepository $chapterRepository,
        ContentRepository $contentRepository,
        ContentTypeRepository $contentTypeRepository
    ) {
        $this->chapterRepository = $chapterRepository;
        $this->contentRepository = $contentRepository;
        $this->contentTypeRepository = $contentTypeRepository;
    }

    public function prepare(mixed $input): mixed
    {
        /** @var \App\Entity\Chapter */
        $chapter = $this->chapterRepository->findOneBy([
            'id' => $input->chapter_id
        ]);

        if(!$chapter) {
            throw new NotFoundHttpException('Chapter not found');
        }

        /** @var \App\Entity\ContentType */
        $contentType = $this->contentTypeRepository->findOneBy([
            'id' => $input->content_type_id,
        ]);

        if(!$contentType) {
            throw new NotFoundHttpException('Content type not found');
        }

        /** @var \App\Entity\Content|null */
        $parentContent = $this->contentRepository->findOneBy([
            'chapter' => $chapter->getId(),
            'id' => $input->parent_id
        ]);

        /** @var \App\Entity\Content|null */
        $previousContent = $this->contentRepository->findOneBy([
            'chapter' => $chapter->getId(),
            'parentContent' => $parentContent?->getId(),
            'nextContent' => null
        ]);

        return new PreparedContentInput(
            $chapter,
            $parentContent,
            $previousContent,
            $contentType
        );
    }
}
