<?php

namespace App\Api\V1\Dto\Courses\ContentType;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContentTypeInput {
    #[NotBlank()]
    #[Length(
        min: 3,
        max: 100,
        minMessage: 'Your first name must be at least {{ limit }} characters long',
        maxMessage: 'Your first name cannot be longer than {{ limit }} characters',
    )]
    public string $name;
}