<?php

namespace App\Api\V1\Mapper\Course;

use App\Api\V1\Dto\Course\CourseOutput;
use App\Entity\Course;

class CourseMapper
{
    public static function fromEntity(Course $course): CourseOutput
    {
        return new CourseOutput(
            $course->getId(),
            $course->getCreatedAt(),
            $course->getUpdatedAt()
        );
    }
}
