<?php

namespace App\Api\V1\State\Courses\Chapter;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Api\V1\Mapper\Courses\Chapter\ChapterMapper;
use App\Api\V1\Services\Courses\Chapter\ChapterPreparer;
use App\Entity\Chapter;
use App\Entity\Translation;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

class ChapterProcessor implements ProcessorInterface
{

    private EntityManagerInterface $em;
    private ChapterPreparer $preparer;

    public function __construct(
        EntityManagerInterface $em,
        ChapterPreparer $preparer
    ) {
        $this->em = $em;
        $this->preparer = $preparer;
    }

    public function process(
        mixed $data,
        Operation $operation,
        array $uriVariables = [],
        array $context = []
    ) {

        /** @var \App\Api\V1\Dto\Courses\Chapter\PreparedChapterInput */
        $preparedInput = $this->preparer->prepare($data);

        $chapter = new Chapter();
        $chapter
            ->setCourse($preparedInput->course)
            ->setPreviousChapter($preparedInput->previousChapter)
            ->setTranslation(new Translation())
            ->setCreatedAt(new DateTime())
            ->setUpdatedAt(new DateTime())
        ;

        if($preparedInput->previousChapter) {
            $preparedInput->previousChapter->setNextChapter($chapter);
            $this->em->persist($preparedInput->previousChapter);
        }

        $this->em->persist($chapter);
        $this->em->flush();

        return ChapterMapper::fromEntity($chapter);
    }
}
