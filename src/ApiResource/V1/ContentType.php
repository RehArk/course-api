<?php

namespace App\ApiResource\V1;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Api\V1\Dto\ContentType\ContentTypeInput;
use App\Api\V1\Dto\ContentType\ContentTypeOutput;
use App\Api\V1\State\ContentType\ContentTypeProcessor;
use App\Api\V1\State\ContentType\ContentTypeProvider;

#[ApiResource(
    routePrefix: '/v1',
    operations: [
        new Get(
            output: ContentTypeOutput::class,
            provider: ContentTypeProvider::class,
            name: 'get_content_type_by_id'
        ),
        new GetCollection(
            output: ContentTypeOutput::class,
            provider: ContentTypeProvider::class,
            name: 'get_all_content_types'
        ),
        new Post(
            input: ContentTypeInput::class,
            output: ContentTypeOutput::class,
            processor: ContentTypeProcessor::class,
            name: 'create_content_type_course'
        )
    ]
)]
class ContentType
{
    private int $id;
    private string $name;
}
