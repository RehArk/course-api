<?php

namespace App\Tests\Mapper\Courses\Chapter;

use App\Api\V1\Dto\Courses\Content\ContentOutput;
use App\Api\V1\Dto\Courses\ContentType\ContentTypeOutput;
use App\Api\V1\Mapper\Courses\Content\ContentMapper;
use App\Entity\Chapter;
use App\Entity\Content;
use App\Entity\ContentType;
use App\Entity\Translation;
use DateTime;
use PHPUnit\Framework\TestCase;

class ContentMapperTest extends TestCase
{
    public function testFromEntity(): void
    {
        $id = '111e4567-e89b-12d3-a456-426614174000';
        $chapter_id = '222e4567-e89b-12d3-a456-426614174000';
        $parent_content_id = null;
        $previous_content_id = null;
        $next_content_id = null;
        $content_type_id = 1;
        $content_text = 'Content test';
        $createdAt = new DateTime();
        $updatedAt = new DateTime();

        $translation = $this->createMock(Translation::class);
        $translation->method('getText')->willReturn($content_text);

        $chapter = $this->createMock(Chapter::class);
        $chapter->method('getId')->willReturn($chapter_id);

        $contentType = $this->createMock(ContentType::class);
        $contentType->method('getId')->willReturn($content_type_id);

        $content = $this->createMock(Content::class);
        $content->method('getId')->willReturn($id);
        $content->method('getChapter')->willReturn($chapter);
        $content->method('getParentContent')->willReturn($parent_content_id);
        $content->method('getPreviousContent')->willReturn($previous_content_id);
        $content->method('getNextContent')->willReturn($next_content_id);
        $content->method('getType')->willReturn($contentType);
        $content->method('getTranslation')->willReturn($translation);
        $content->method('getCreatedAt')->willReturn($createdAt);
        $content->method('getUpdatedAt')->willReturn($updatedAt);

        $dto = (new ContentMapper)->fromEntity($content);
        
        $this->assertInstanceOf(ContentOutput::class, $dto);
        $this->assertSame($chapter_id, $dto->chapter);
        $this->assertSame($parent_content_id, $dto->parentContent);
        $this->assertSame($previous_content_id, $dto->previousContent);
        $this->assertSame($next_content_id, $dto->nextContent);
        $this->assertSame($content_type_id, $dto->type);
        $this->assertSame($content_text, $dto->content);
        $this->assertSame($createdAt, $dto->createdAt);
        $this->assertSame($updatedAt, $dto->updatedAt);
    }
    
}
