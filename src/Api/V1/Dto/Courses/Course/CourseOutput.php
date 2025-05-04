<?php

namespace App\Api\V1\Dto\Courses\Course;

use DateTime;

class CourseOutput {

    public string $id;
    public DateTime $createdAt;
    public DateTime $updatedAt;

    public function __construct(
        string $id,
        DateTime $createdAt,
        DateTime $updatedAt
    ) {
        $this->id = $id;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

}