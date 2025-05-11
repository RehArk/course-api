<?php

namespace App\ApiResource\V1;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use App\Api\Utils\ApiResourceInterface;
use App\Api\V1\Dto\Courses\Content\ContentInput;
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
            provider: ContentProvider::class,
            name: 'get_content_by_id'
        ),
        new Post(
            input: ContentInput::class,
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

    public string $id;
    public string $chapter;
    public ?string $parentContent;
    public ?string $previousContent;
    public ?string $nextContent;
    public int $type;
    public string $content;
    public DateTime $createdAt;
    public DateTime $updatedAt;

    public function __construct(
        string $id,
        string $chapter,
        ?string $parentContent,
        ?string $previousContent,
        ?string $nextContent,
        int $type,
        string $content,
        DateTime $createdAt,
        DateTime $updatedAt
    ) {
        $this->id = $id;
        $this->chapter = $chapter;
        $this->parentContent = $parentContent;
        $this->previousContent = $previousContent;
        $this->nextContent = $nextContent;
        $this->type = $type;
        $this->content = $content;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }
    
    public static function getEntityClass() : string {
        return EntityContent::class;
    }
}
