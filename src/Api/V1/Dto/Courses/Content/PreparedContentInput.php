<?php

namespace App\Api\V1\Dto\Courses\Content;

use App\Entity\Chapter;
use App\Entity\Content;
use App\Entity\ContentType;

class PreparedContentInput
{
    public Chapter $chapter;
    public ?Content $parentContent = null;
    public ?Content $previousContent = null;
    public ContentType $contentType;

    public function __construct(
        Chapter $chapter,
        ?Content $parentContent,
        ?Content $previousContent,
        ContentType $contentType,
    ) {
        $this->chapter = $chapter;
        $this->parentContent = $parentContent;
        $this->previousContent = $previousContent;
        $this->contentType = $contentType;
    }
}
