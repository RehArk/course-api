<?php

namespace App\Api\V1\Dto\Courses\Content;

use App\Entity\Chapter;
use App\Entity\Content;
use App\Entity\ContentType;

/**
 * @codeCoverageIgnore
 */
class PreparedContentInput
{
    public Chapter $chapter;
    public ?Content $parentContent = null;
    public ?Content $previousContent = null;
    public ContentType $contentType;
    public string $defaultContent;

    public function __construct(
        Chapter $chapter,
        ?Content $parentContent,
        ?Content $previousContent,
        ContentType $contentType,
        string $defaultContent
    ) {
        $this->chapter = $chapter;
        $this->parentContent = $parentContent;
        $this->previousContent = $previousContent;
        $this->contentType = $contentType;
        $this->defaultContent = $defaultContent;
    }
}
