<?php

namespace App\Api\V1\Mapper\Courses\Chapter;

use App\ApiResource\V1\Chapter as ApiChapter;
use App\Entity\Chapter;
use App\Utils\Mapper\AbstractMapper;

class ChapterMapper extends AbstractMapper
{
    /**
     * @param Chapter $entity
     * 
     * @return ApiChapter
     */
    public function fromEntity(mixed $chapter): mixed
    {
        return new ApiChapter(
            $chapter->getId(),
            $chapter->getCourse()->getId(),
            $chapter->getPreviousChapter()?->getId(),
            $chapter->getNextChapter()?->getId(),
            $chapter->getTranslation()->getText(),
            $chapter->getCreatedAt(),
            $chapter->getUpdatedAt()
        );
    }
}
