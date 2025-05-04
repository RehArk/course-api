<?php

namespace App\Api\V1\Mapper\Courses\Course;

use App\Api\V1\Dto\Courses\Course\CourseOutput;
use App\Entity\Course;

class CourseMapper
{
    public static function fromEntity(Course $course): CourseOutput
    {
        return new CourseOutput(
            $course->getId(),
            $course->getTranslation()->getText(),
            $course->getCreatedAt(),
            $course->getUpdatedAt()
        );
    }
}
