<?php

namespace App\Api\V1\Dto\Courses\Course;

class PreparedCourseInput {

    public string $defaultTitle;

    public function __construct(
        string $defaultTitle
    ) {
      $this->defaultTitle = $defaultTitle;  
    }
}