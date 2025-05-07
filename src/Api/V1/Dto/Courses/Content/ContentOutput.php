<?php

namespace App\Api\V1\Dto\Courses\Content;

use DateTime;

class ContentOutput
{
    public string $id;
    public string $chapter;
    public ?string $parentContent;
    public ?string $previousContent;
    public ?string $nextContent;
    public int $type;
    public ?string $content;
    public DateTime $createdAt;
    public DateTime $updatedAt;

    public function __construct(
        string $id,
        string $chapter,
        ?string $parentContent,
        ?string $previousContent,
        ?string $nextContent,
        int $type,
        ?string $content,
        DateTime $createdAt,
        DateTime $updatedAt
    ) {
        $this->id = $id;
        $this->chapter = $chapter;
        $this->parentContent = $parentContent;
        $this->previousContent = $previousContent;
        $this->nextContent = $nextContent;
        $this->type = $type;
        $this->content = $content;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }
}
