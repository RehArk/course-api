<?php

namespace App\ApiResource\V1;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use App\Api\V1\Dto\Content\ContentInput;
use App\Api\V1\Dto\Content\ContentOutput;
use App\Api\V1\State\Content\ContentProcessor;
use App\Api\V1\State\Content\ContentProvider;
use App\Entity\Translation;
use DateTime;

#[ApiResource(
    routePrefix: '/v1',
    operations: [
        new Get(
            output: ContentOutput::class,
            provider: ContentProvider::class,
            name: 'get_content_by_id'
        ),
        new Post(
            input: ContentInput::class,
            output: ContentOutput::class,
            processor: ContentProcessor::class,
            name: 'create_content'
        )
    ]
)]
class Content
{
    private string $id;
    private Chapter $chapter;
    private ?Content $parentContent;
    private ?Content $previousContent;
    private ?Content $nextContent;
    private Translation $translation;
    private ContentType $type;
    private DateTime $createdAt;
    private DateTime $updatedAt;
}
