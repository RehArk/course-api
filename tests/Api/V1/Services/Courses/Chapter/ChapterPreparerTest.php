<?php

namespace App\Tests\Api\V1\Services\Courses\Chapter;

use App\Api\V1\Dto\Courses\Chapter\ChapterInput;
use App\Api\V1\Dto\Courses\Chapter\PreparedChapterInput;
use App\Api\V1\Services\Courses\Chapter\ChapterPreparer;
use App\Entity\Course;
use App\Repository\ChapterRepository;
use App\Repository\CourseRepository;
use PHPUnit\Framework\TestCase;

class ChapterPreparerTest extends TestCase
{


    public function testPrepare()
    {
        $chapterInput = new ChapterInput();
        $chapterInput->course_id = '1';
        $chapterInput->default_title = 'Test';

        /** @var \PHPUnit\Framework\MockObject\MockObject&\App\Entity\Course $course */
        $course = $this->createMock(Course::class);
        $course
            ->expects($this->once())
            ->method('getId')
            ->willReturn($chapterInput->course_id)
        ;

        /** @var \PHPUnit\Framework\MockObject\MockObject&\App\Repository\ChapterRepository $chapterRepository */
        $chapterRepository = $this->createMock(ChapterRepository::class);
        $chapterRepository
            ->expects($this->once())
            ->method('findOneBy')
            ->with([
                'course' => $chapterInput->course_id,
                'nextChapter' => null,
            ])
            ->willReturn(null)
        ;

        /** @var \PHPUnit\Framework\MockObject\MockObject&\App\Repository\CourseRepository $courseRepository */
        $courseRepository = $this->createMock(CourseRepository::class);
        $courseRepository
            ->expects($this->once())
            ->method('findOneBy')
            ->with(['id' => $chapterInput->course_id])
            ->willReturn($course)
        ;

        $chapterPreparer = new ChapterPreparer($chapterRepository, $courseRepository);
        $res = $chapterPreparer->prepare($chapterInput);

        $this->assertEquals($res, new PreparedChapterInput(
            $course,
            null,
            $chapterInput->default_title
        ));
    }

    public function testPrepareWithNoCourseFail()
    {
        $chapterInput = new ChapterInput();
        $chapterInput->course_id = '1';
        $chapterInput->default_title = 'Test';

        /** @var \PHPUnit\Framework\MockObject\MockObject&\App\Repository\ChapterRepository $chapterRepository */
        $chapterRepository = $this->createMock(ChapterRepository::class);

        /** @var \PHPUnit\Framework\MockObject\MockObject&\App\Repository\CourseRepository $courseRepository */
        $courseRepository = $this->createMock(CourseRepository::class);
        $courseRepository
            ->expects($this->once())
            ->method('findOneBy')
            ->with(['id' => $chapterInput->course_id])
            ->willReturn(null);

        $chapterPreparer = new ChapterPreparer($chapterRepository, $courseRepository);

        $this->expectException(\Symfony\Component\HttpKernel\Exception\NotFoundHttpException::class);
        $this->expectExceptionMessage('Course not found');

        $chapterPreparer->prepare(
            $chapterInput
        );
    }
}
