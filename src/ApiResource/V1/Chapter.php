<?php

namespace App\ApiResource\V1;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use App\Api\Utils\ApiResourceInterface;
use App\Api\V1\Dto\Courses\Chapter\ChapterInput;
use App\Api\V1\Dto\Translation\TranslationInput;
use App\Api\V1\State\Courses\Chapter\ChapterProcessor;
use App\Api\V1\State\Courses\Chapter\ChapterProvider;
use App\Api\V1\State\Translation\TranslationProcessor;
use App\Entity\Chapter as EntityChapter;
use App\Entity\Translation;
use DateTime;

#[ApiResource(
    routePrefix: '/v1',
    operations: [
        new Get(
            provider: ChapterProvider::class,
            name: 'get_chapter_by_id'
        ),
        new Post(
            input: ChapterInput::class,
            processor: ChapterProcessor::class,
            name: 'create_chapter'
        ),
        new Post(
            uriTemplate: '/chapters/{id}/translation',
            controller: null,
            processor: TranslationProcessor::class,
            input: TranslationInput::class,
            name: 'create_or_update_chapter_translation'
        )
    ]
)]
class Chapter implements ApiResourceInterface
{

    public string $id;
    public string $course;
    public ?string $previousChapter;
    public ?string $nextChapter;
    public string $title;
    public DateTime $createdAt;
    public DateTime $updatedAt;

    public function __construct(
        string $id,
        string $course,
        ?string $previousChapter,
        ?string $nextChapter,
        string $title,
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

    public static function getEntityClass() : string {
        return EntityChapter::class;
    }

}
