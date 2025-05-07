<?php

namespace App\Api\V1\Dto\Courses\Chapter;

use DateTime;

class ChapterOutput {

    public string $id;
    public string $course;
    public ?string $previousChapter;
    public ?string $nextChapter;
    public ?string $title;
    public DateTime $createdAt;
    public DateTime $updatedAt;

    public function __construct(
        string $id,
        string $course,
        ?string $previousChapter,
        ?string $nextChapter,
        ?string $title,
        DateTime $createdAt,
        DateTime $updatedAt
    ) {
        $this->id = $id;
        $this->course = $course;
        $this->previousChapter = $previousChapter;
        $this->nextChapter = $nextChapter;
        $this->title = $title;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

}