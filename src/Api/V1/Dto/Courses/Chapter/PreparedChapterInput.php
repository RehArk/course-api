<?php

namespace App\Api\V1\Dto\Courses\Chapter;

use App\Entity\Chapter;
use App\Entity\Course;

class PreparedChapterInput
{

    public Course $course;
    public ?Chapter $previousChapter = null;

    public function __construct(
        Course $course,
        ?Chapter $previousChapter
    ) {
        $this->course = $course;
        $this->previousChapter = $previousChapter;
    }
}
