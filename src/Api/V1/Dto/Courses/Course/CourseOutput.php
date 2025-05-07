<?php

namespace App\Api\V1\Dto\Courses\Course;

use DateTime;

class CourseOutput {

    public string $id;
    public ?string $title;
    public DateTime $createdAt;
    public DateTime $updatedAt;

    public function __construct(
        string $id,
        ?string $title,
        DateTime $createdAt,
        DateTime $updatedAt
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

}