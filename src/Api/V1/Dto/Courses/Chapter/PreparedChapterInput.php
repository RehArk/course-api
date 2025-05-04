<?php

namespace App\Api\V1\Dto\Courses\Chapter;

use App\Entity\Chapter;
use App\Entity\Course;

/**
 * @codeCoverageIgnore
 */
class PreparedChapterInput
{

    public Course $course;
    public ?Chapter $previousChapter = null;
    public string $defaultTitle;

    public function __construct(
        Course $course,
        ?Chapter $previousChapter,
        string $defaultTitle
    ) {
        $this->course = $course;
        $this->previousChapter = $previousChapter;
        $this->defaultTitle = $defaultTitle;
    }
}
