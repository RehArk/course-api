<?php

namespace App\Api\V1\Dto\Courses\Content;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class ContentInput
{
    #[NotNull()]
    #[NotBlank()]
    #[Assert\Uuid()]
    public string $chapter_id;

    #[Assert\Uuid()]
    public ?string $parent_id = null;

    #[NotNull()]
    #[NotBlank()]
    #[Assert\Type(type: 'integer')]
    #[Assert\Positive]
    public int $content_type_id;

    #[NotNull()]
    #[NotBlank(['normalizer' => 'trim'])]
    public string $default_content;
}
