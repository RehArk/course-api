<?php

namespace App\ApiResource\V1;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Api\Utils\ApiResourceInterface;
use App\Api\V1\Dto\Courses\ContentType\ContentTypeInput;
use App\Api\V1\Dto\Courses\ContentType\ContentTypeOutput;
use App\Api\V1\State\Courses\ContentType\ContentTypeProcessor;
use App\Api\V1\State\Courses\ContentType\ContentTypeProvider;
use App\Entity\ContentType as EntityContentType;

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
class ContentType implements ApiResourceInterface
{
    private int $id;
    private string $name;

    public static function getEntityClass() : string {
        return EntityContentType::class;
    }
}
