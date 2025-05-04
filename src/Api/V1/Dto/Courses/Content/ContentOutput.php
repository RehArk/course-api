<?php

namespace App\Api\V1\Dto\Courses\Content;

use App\Entity\Chapter;
use App\Entity\Content;
use App\Entity\ContentType;
use DateTime;

class ContentOutput
{

    public string $id;
    public string $chapter;
    public ?string $parentContent;
    public ?string $previousContent;
    public ?string $nextContent;
    public string $type;
    public DateTime $createdAt;
    public DateTime $updatedAt;

    public function __construct(
        string $id,
        string $chapter,
        ?string $parentContent,
        ?string $previousContent,
        ?string $nextContent,
        int $type,
        DateTime $createdAt,
        DateTime $updatedAt
    ) {
        $this->id = $id;
        $this->chapter = $chapter;
        $this->parentContent = $parentContent;
        $this->previousContent = $previousContent;
        $this->nextContent = $nextContent;
        $this->type = $type;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }
}
