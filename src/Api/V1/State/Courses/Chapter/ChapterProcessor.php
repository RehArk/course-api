<?php

namespace App\Api\V1\State\Courses\Chapter;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Api\V1\Mapper\Courses\Chapter\ChapterMapper;
use App\Entity\Chapter;
use App\Entity\Translation;
use App\Repository\ChapterRepository;
use App\Repository\CourseRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ChapterProcessor implements ProcessorInterface
{

    private EntityManagerInterface $em;
    private ChapterRepository $chapterRepository;
    private CourseRepository $courseRepository;

    public function __construct(
        EntityManagerInterface $em,
        ChapterRepository $chapterRepository,
        CourseRepository $courseRepository
    ) {
        $this->em = $em;
        $this->chapterRepository = $chapterRepository;
        $this->courseRepository = $courseRepository;
    }

    public function process(
        mixed $data,
        Operation $operation,
        array $uriVariables = [],
        array $context = []
    ) {

        /** @var \App\Entity\Course */
        $course = $this->courseRepository->findOneBy(['id' => $data->course_id]);

        if (!$course) {
            throw new NotFoundHttpException('Course not found');
        }

        /** @var \App\Entity\Chapter */
        $previousChapter = $this->chapterRepository->findOneBy([
            'course' => $course->getId(),
            'nextChapter' => null
        ]);

        $chapter = new Chapter();
        $chapter
            ->setCourse($course)
            ->setPreviousChapter($previousChapter)
            ->setTranslation(new Translation())
            ->setCreatedAt(new DateTime())
            ->setUpdatedAt(new DateTime())
        ;

        if($previousChapter) {
            $previousChapter->setNextChapter($chapter);
            $this->em->persist($previousChapter);
        }

        $this->em->persist($chapter);
        $this->em->flush();

        return ChapterMapper::fromEntity($chapter);
    }
}
