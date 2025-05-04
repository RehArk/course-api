<?php

namespace App\Api\V1\Services\Courses\Course;

use App\Api\V1\Dto\Courses\Course\PreparedCourseInput;
use App\Api\V1\Services\PreparerInterface;

class CoursePreparer implements PreparerInterface {

    public function prepare(mixed $input): mixed
    {
        return new PreparedCourseInput(
            $input->default_title
        );
    }
}