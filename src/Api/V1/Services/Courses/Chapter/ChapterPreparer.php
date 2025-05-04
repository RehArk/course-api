<?php

namespace App\Api\V1\Services\Courses\Chapter;

use App\Api\V1\Dto\Courses\Chapter\PreparedChapterInput;
use App\Api\V1\Services\PreparerInterface;
use App\Repository\ChapterRepository;
use App\Repository\CourseRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ChapterPreparer implements PreparerInterface {

    private ChapterRepository $chapterRepository;
    private CourseRepository $courseRepository;

    public function __construct(
        ChapterRepository $chapterRepository,
        CourseRepository $courseRepository
    ) {
        $this->chapterRepository = $chapterRepository;
        $this->courseRepository = $courseRepository;
    }

    public function prepare(mixed $input): mixed
    {
        /** @var \App\Entity\Course */
        $course = $this->courseRepository->findOneBy(['id' => $input->course_id]);

        if (!$course) {
            throw new NotFoundHttpException('Course not found');
        }

        /** @var \App\Entity\Chapter */
        $previousChapter = $this->chapterRepository->findOneBy([
            'course' => $course->getId(),
            'nextChapter' => null
        ]);

        return new PreparedChapterInput(
            $course,
            $previousChapter
        );
    }
}