<?php

namespace App\Api\V1\Dto\Courses\Chapter;

use Symfony\Component\Validator\Constraints as Assert;

class ChapterInput {
    #[Assert\Uuid]
    public string $course_id;
}