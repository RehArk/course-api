<?php

namespace App\Api\V1\Dto\Chapter;

use App\Entity\Chapter;
use DateTime;

class ChapterOutput {

    public string $id;
    public string $course;
    public ?string $previousChapter;
    public ?string $nextChapter;
    public DateTime $createdAt;
    public DateTime $updatedAt;

    public function __construct(
        string $id,
        string $course,
        ?string $previousChapter,
        ?string $nextChapter,
        DateTime $createdAt,
        DateTime $updatedAt
    ) {
        $this->id = $id;
        $this->course = $course;
        $this->previousChapter = $previousChapter;
        $this->nextChapter = $nextChapter;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

}