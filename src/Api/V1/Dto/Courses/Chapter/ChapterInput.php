<?php

namespace App\Api\V1\Dto\Courses\Chapter;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class ChapterInput
{
    #[NotNull()]
    #[NotBlank()]
    #[Assert\Uuid]
    public string $course_id;

    #[NotNull()]
    #[NotBlank()]
    #[Length(
        min: 3,
        max: 100,
        minMessage: 'The title must be at least {{ limit }} characters long',
        maxMessage: 'The title cannot be longer than {{ limit }} characters',
    )]
    #[Assert\Regex(
        pattern: '/^[\p{L}\s]+$/u',
        message: 'This field must contain letters only.'
    )]
    public string $default_title;
}
