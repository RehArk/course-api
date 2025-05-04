<?php

namespace App\Api\V1\Mapper\Courses\Content;

use App\Api\V1\Dto\Courses\Content\ContentOutput;
use App\Entity\Content;

class ContentMapper {

    public static function fromEntity(
        Content $content
    ) : ContentOutput {
        return new ContentOutput(
            $content->getId(),
            $content->getChapter()->getId(),
            $content->getParentContent()?->getId(),
            $content->getPreviousContent()?->getId(),
            $content->getNextContent()?->getId(),
            $content->getType()->getId(),
            $content->getCreatedAt(),
            $content->getUpdatedAt()
        );
    }
    
}