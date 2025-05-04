<?php

namespace App\Api\V1\Dto\Courses\Content;
use Symfony\Component\Validator\Constraints as Assert;


class ContentInput
{
    #[Assert\Uuid()]
    public string $chapter_id;

    #[Assert\Uuid()]
    public ?string $parent_id = null;

    #[Assert\Type(type: 'integer')]
    #[Assert\Positive]
    public int $content_type_id;
}
