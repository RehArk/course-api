<?php

namespace App\Tests\Api\V1\State\Courses\Content;

use App\Api\V1\State\Courses\Content\ContentProvider;
use App\Api\V1\Mapper\Courses\Content\ContentMapper;
use App\Entity\Content;
use App\Repository\ContentRepository;
use ApiPlatform\Metadata\Operation;
use App\Api\V1\Dto\Courses\Content\ContentOutput;
use DateTime;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ContentProviderTest extends TestCase
{
    public function testProvideReturnsMappedContent()
    {
        $id = '1';
        $chapter_id = '1';
        $content_type_id = 1;
        $content_text = 'Test';

        $dto = new ContentOutput(
            $id,
            $chapter_id,
            null,
            null,
            null,
            $content_type_id,
            $content_text,
            new DateTime(),
            new DateTime()
        );

        $content = $this->createMock(Content::class);

        /** @var \PHPUnit\Framework\MockObject\MockObject&\App\Repository\ContentRepository $repository */
        $repository = $this->createMock(ContentRepository::class);
        $repository->method('findOneBy')
            ->with(['id' => $id])
            ->willReturn($content);

        /** @var \PHPUnit\Framework\MockObject\MockObject&\App\Api\V1\Mapper\Courses\Content\ContentMapper $mapper */
        $mapper = $this->createMock(ContentMapper::class);
        $mapper->expects($this->once())
            ->method('fromEntity')
            ->with($content)
            ->willReturn($dto);

        $provider = new ContentProvider($repository, $mapper);

        /** @var \PHPUnit\Framework\MockObject\MockObject&\ApiPlatform\Metadata\Operation $operation */
        $operation = $this->createMock(Operation::class);

        $result = $provider->provide($operation, ['id' => $id]);

        $this->assertSame($dto, $result);
    }

    public function testProvideThrowsNotFoundWhenContentMissing()
    {
        $id = '1';

        /** @var \PHPUnit\Framework\MockObject\MockObject&\App\Repository\ContentRepository $repository */
        $repository = $this->createMock(ContentRepository::class);
        $repository->method('findOneBy')
            ->with(['id' => $id])
            ->willReturn(null);

        /** @var \PHPUnit\Framework\MockObject\MockObject&\App\Api\V1\Mapper\Courses\Content\ContentMapper $mapper */
        $mapper = $this->createMock(ContentMapper::class);

        $provider = new ContentProvider($repository, $mapper);

        /** @var \PHPUnit\Framework\MockObject\MockObject&\ApiPlatform\Metadata\Operation $operation */
        $operation = $this->createMock(Operation::class);

        $this->expectException(NotFoundHttpException::class);

        $provider->provide($operation, ['id' => $id]);
    }
}
