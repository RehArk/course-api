<?php

namespace App\Api\V1\State\Courses\Chapter;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Api\V1\Mapper\Courses\Chapter\ChapterMapper;
use App\Api\V1\Services\Courses\Chapter\ChapterPreparer;
use App\Entity\Chapter;
use App\Factory\TranslationFactory;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

class ChapterProcessor implements ProcessorInterface
{

    private EntityManagerInterface $em;
    private ChapterPreparer $preparer;
    private TranslationFactory $translationFactory;
    private ChapterMapper $mapper;

    public function __construct(
        EntityManagerInterface $em,
        ChapterPreparer $preparer,
        TranslationFactory $translationFactory,
        ChapterMapper $mapper
    ) {
        $this->em = $em;
        $this->preparer = $preparer;
        $this->translationFactory = $translationFactory;
        $this->mapper = $mapper;
    }

    /**
     * Handles the state.
     *
     * @param T1                                                                                                                        $data
     * @param array<string, mixed>                                                                                                      $uriVariables
     * @param array<string, mixed>&array{request?: Request, previous_data?: mixed, resource_class?: string|null, original_data?: mixed} $context
     *
     * @return T2
     */
    public function process(
        mixed $data,
        Operation $operation,
        array $uriVariables = [],
        array $context = []
    ) {

        /** @var \App\Api\V1\Dto\Courses\Chapter\PreparedChapterInput */
        $preparedInput = $this->preparer->prepare($data);

        $defaultTranslation = $this->translationFactory
            ->createWithDefaultEnglishText($preparedInput->defaultTitle)
        ;

        $chapter = new Chapter();
        $chapter
            ->setCourse($preparedInput->course)
            ->setPreviousChapter($preparedInput->previousChapter)
            ->setTranslation($defaultTranslation)
            ->setCreatedAt(new DateTime())
            ->setUpdatedAt(new DateTime())
        ;

        if ($preparedInput->previousChapter) {
            $preparedInput->previousChapter->setNextChapter($chapter);
            $this->em->persist($preparedInput->previousChapter);
        }

        $this->em->persist($chapter);
        $this->em->flush();

        return $this->mapper->fromEntity($chapter);
    }
}
