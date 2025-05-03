<?php

namespace App\Api\V1\Mapper\Chapter;

use App\Api\V1\Dto\Chapter\ChapterOutput;
use App\Entity\Chapter;

class ChapterMapper
{
    public static function fromEntity(Chapter $chapter): ChapterOutput
    {
        return new ChapterOutput(
            $chapter->getId(),
            $chapter->getCourse()->getId(),
            $chapter->getPreviousChapter()?->getId(),
            $chapter->getNextChapter()?->getId(),
            $chapter->getCreatedAt(),
            $chapter->getUpdatedAt()
        );
    }
}
