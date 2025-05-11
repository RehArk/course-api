<?php

namespace App\Tests\Mapper\Courses\Course;

use App\Api\V1\Mapper\Courses\Course\CourseMapper;
use App\ApiResource\V1\Course as ApiCourse;
use App\Entity\Course;
use App\Entity\Translation;
use DateTime;
use PHPUnit\Framework\TestCase;

class CourseMapperTest extends TestCase
{
    public function testFromEntity(): void
    {
        $courseId = '111e4567-e89b-12d3-a456-426614174000';
        $title = 'Cours test';
        $createdAt = new DateTime();
        $updatedAt = new DateTime();

        $translation = $this->createMock(Translation::class);
        $translation->method('getText')->willReturn($title);

        $course = $this->createMock(Course::class);
        $course->method('getId')->willReturn($courseId);
        $course->method('getTranslation')->willReturn($translation);
        $course->method('getCreatedAt')->willReturn($createdAt);
        $course->method('getUpdatedAt')->willReturn($updatedAt);

        /** @var \PHPUnit\Framework\MockObject\MockObject&\App\Entity\Course $course */
        $dto = (new CourseMapper)->fromEntity($course);

        $this->assertInstanceOf(ApiCourse::class, $dto);
        $this->assertSame($courseId, $dto->id);
        $this->assertSame($title, $dto->title);
        $this->assertSame($createdAt, $dto->createdAt);
        $this->assertSame($updatedAt, $dto->updatedAt);
    }
}
