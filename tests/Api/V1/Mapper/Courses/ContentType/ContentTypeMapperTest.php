<?php

namespace App\Tests\Mapper\Courses\ContentType;

use App\Api\V1\Dto\Courses\ContentType\ContentTypeOutput;
use App\Api\V1\Mapper\Courses\ContentType\ContentTypeMapper;
use App\Entity\ContentType;
use PHPUnit\Framework\TestCase;

class ContentTypeMapperTest extends TestCase
{
    public function testFromEntity(): void
    {
        $id = 1;
        $name = 'title';

        $contentType = $this->createMock(ContentType::class);
        $contentType->method('getId')->willReturn($id);
        $contentType->method('getName')->willReturn($name);

        $dto = (new ContentTypeMapper)->fromEntity($contentType);

        $this->assertInstanceOf(ContentTypeOutput::class, $dto);
        $this->assertSame($id, $dto->id);
        $this->assertSame($name, $dto->name);
    }

    public function testFromArray(): void
    {
        $contentType1 = $this->createMock(ContentType::class);
        $contentType2 = $this->createMock(ContentType::class);

        $contentType1->method('getId')->willReturn(1);
        $contentType1->method('getName')->willReturn('title');

        $contentType2->method('getId')->willReturn(2);
        $contentType2->method('getName')->willReturn('paragraph');

        $result = (new ContentTypeMapper)->fromArray([$contentType1, $contentType2]);

        $this->assertCount(2, $result);
        $this->assertContainsOnlyInstancesOf(ContentTypeOutput::class, $result);

        $this->assertSame(1, $result[0]->id);
        $this->assertSame('title', $result[0]->name);
        $this->assertSame(2, $result[1]->id);
        $this->assertSame('paragraph', $result[1]->name);
    }
}
