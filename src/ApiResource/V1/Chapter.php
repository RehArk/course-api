<?php

namespace App\ApiResource\V1;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use App\Api\V1\Dto\Courses\Chapter\ChapterInput;
use App\Api\V1\Dto\Courses\Chapter\ChapterOutput;
use App\Api\V1\State\Courses\Chapter\ChapterProcessor;
use App\Api\V1\State\Courses\Chapter\ChapterProvider;
use App\Entity\Translation;
use DateTime;

#[ApiResource(
    routePrefix: '/v1',
    operations: [
        new Get(
            output: ChapterOutput::class,
            provider: ChapterProvider::class,
            name: 'get_chapter_by_id'
        ),
        new Post(
            input: ChapterInput::class,
            output: ChapterOutput::class,
            processor: ChapterProcessor::class,
            name: 'create_chapter'
        )
    ]
)]
class Chapter
{
    private string $id;
    private Course $course;
    private Translation $translation;
    private ?Chapter $previousChapter;
    private ?Chapter $nextChapter;
    private DateTime $createdAt;
    private DateTime $updatedAt;
}
