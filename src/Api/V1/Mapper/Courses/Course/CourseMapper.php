<?php

namespace App\Api\V1\Mapper\Courses\Course;

use App\ApiResource\V1\Course as ApiCourse;
use App\Utils\Mapper\AbstractMapper;
use App\Entity\Course;

class CourseMapper extends AbstractMapper
{

    /**
     * @param Course $entity
     * 
     * @return ApiCourse
     */
    public function fromEntity(
        mixed $course
    ): mixed {
        return new ApiCourse(
            $course->getId(),
            $course->getTranslation()->getText(),
            $course->getCreatedAt(),
            $course->getUpdatedAt()
        );
    }
}
