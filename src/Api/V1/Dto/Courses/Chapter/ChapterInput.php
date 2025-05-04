<?php

namespace App\Api\V1\Dto\Courses\Chapter;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class ChapterInput
{
    #[NotNull()]
    #[NotBlank()]
    #[Assert\Uuid]
    public string $course_id;
}
