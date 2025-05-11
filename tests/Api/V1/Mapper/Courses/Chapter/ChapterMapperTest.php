<?php

namespace App\Tests\Mapper\Courses\Chapter;

use App\Api\V1\Mapper\Courses\Chapter\ChapterMapper;
use App\ApiResource\V1\Chapter as ApiChapter;
use App\Entity\Chapter;
use App\Entity\Course;
use App\Entity\Translation;
use DateTime;
use PHPUnit\Framework\TestCase;

class ChapterMapperTest extends TestCase
{
    public function testFromEntity(): void
    {
        $courseId = '111e4567-e89b-12d3-a456-426614174000';
        $chapterId = '222e4567-e89b-12d3-a456-426614174000';
        $prevChapterId = '333e4567-e89b-12d3-a456-426614174000';
        $nextChapterId = '444e4567-e89b-12d3-a456-426614174000';
        $title = 'Chapter test';
        $createdAt = new DateTime();
        $updatedAt = new DateTime();

        $course = $this->createMock(Course::class);
        $course->method('getId')->willReturn($courseId);

        $prevChapter = $this->createMock(Chapter::class);
        $prevChapter->method('getId')->willReturn($prevChapterId);

        $nextChapter = $this->createMock(Chapter::class);
        $nextChapter->method('getId')->willReturn($nextChapterId);

        $translation = $this->createMock(Translation::class);
        $translation->method('getText')->willReturn($title);

        $chapter = $this->createMock(Chapter::class);
        $chapter->method('getId')->willReturn($chapterId);
        $chapter->method('getCourse')->willReturn($course);
        $chapter->method('getPreviousChapter')->willReturn($prevChapter);
        $chapter->method('getNextChapter')->willReturn($nextChapter);
        $chapter->method('getTranslation')->willReturn($translation);
        $chapter->method('getCreatedAt')->willReturn($createdAt);
        $chapter->method('getUpdatedAt')->willReturn($updatedAt);

        $dto = (new ChapterMapper)->fromEntity($chapter);

        $this->assertInstanceOf(ApiChapter::class, $dto);
        $this->assertSame($chapterId, $dto->id);
        $this->assertSame($courseId, $dto->course);
        $this->assertSame($prevChapterId, $dto->previousChapter);
        $this->assertSame($nextChapterId, $dto->nextChapter);
        $this->assertSame($title, $dto->title);
        $this->assertSame($createdAt, $dto->createdAt);
        $this->assertSame($updatedAt, $dto->updatedAt);
    }
}