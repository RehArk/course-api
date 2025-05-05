<?php

namespace App\ApiResource\V1;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use App\Api\Utils\ApiResourceInterface;
use App\Api\V1\Dto\Courses\Content\ContentInput;
use App\Api\V1\Dto\Courses\Content\ContentOutput;
use App\Api\V1\Dto\Translation\TranslationInput;
use App\Api\V1\State\Courses\Content\ContentProcessor;
use App\Api\V1\State\Courses\Content\ContentProvider;
use App\Api\V1\State\Translation\TranslationProcessor;
use App\Entity\Content as EntityContent;
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
        ),
        new Post(
            uriTemplate: '/contents/{id}/translation',
            controller: null,
            processor: TranslationProcessor::class,
            input: TranslationInput::class,
            name: 'create_or_update_content_translation'
        )
    ]
)]
class Content implements ApiResourceInterface
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

    public static function getEntityClass() : string {
        return EntityContent::class;
    }
}
