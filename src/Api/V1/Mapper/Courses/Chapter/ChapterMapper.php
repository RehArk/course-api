<?php

namespace App\Api\V1\Mapper\Courses\Chapter;

use App\Api\V1\Dto\Courses\Chapter\ChapterOutput;
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
