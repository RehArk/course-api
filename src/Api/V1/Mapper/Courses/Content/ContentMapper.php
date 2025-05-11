<?php

namespace App\Api\V1\Mapper\Courses\Content;

use App\ApiResource\V1\Content as ApiContent;
use App\Entity\Content;
use App\Utils\Mapper\AbstractMapper;

class ContentMapper extends AbstractMapper
{

    /**
     * @param Content $entity
     * 
     * @return ApiContent
     */
    public function fromEntity(
        mixed $content
    ): mixed {
        return new ApiContent(
            $content->getId(),
            $content->getChapter()->getId(),
            $content->getParentContent()?->getId(),
            $content->getPreviousContent()?->getId(),
            $content->getNextContent()?->getId(),
            $content->getType()->getId(),
            $content->getTranslation()->getText(),
            $content->getCreatedAt(),
            $content->getUpdatedAt()
        );
    }
}
