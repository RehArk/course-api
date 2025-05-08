<?php

namespace App\Tests\Api\V1\State\Courses\ContentType;

use App\Api\V1\State\Courses\ContentType\ContentTypeProvider;
use App\Api\V1\Mapper\Courses\ContentType\ContentTypeMapper;
use App\Entity\ContentType;
use App\Repository\ContentTypeRepository;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\CollectionOperation;
use ApiPlatform\Metadata\GetCollection;
use App\Api\V1\Dto\Courses\ContentType\ContentTypeOutput;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ContentTypeProviderTest extends TestCase
{
    public function testProvideOneReturnsMappedEntity()
    {

        $id = 1;
        $name = 'Title';

        $dto = new ContentTypeOutput(
            $id,
            $name
        );

        $contentType = $this->createMock(ContentType::class);

        /** @var \PHPUnit\Framework\MockObject\MockObject&\App\Repository\ContentTypeRepository $repository */
        $repository = $this->createMock(ContentTypeRepository::class);
        $repository
            ->method('findOneBy')
            ->with(['id' => $id])
            ->willReturn($contentType)
        ;

        /** @var \PHPUnit\Framework\MockObject\MockObject&\App\Api\V1\Mapper\Courses\ContentType\ContentTypeMapper $mapper */
        $mapper = $this->createMock(ContentTypeMapper::class);
        $mapper->expects($this->once())
            ->method('fromEntity')
            ->with($contentType)
            ->willReturn($dto)
        ;

        $provider = new ContentTypeProvider(
            $repository,
            $mapper
        );

        /** @var \PHPUnit\Framework\MockObject\MockObject&\ApiPlatform\Metadata\Operation $operation */
        $operation = $this->createMock(Operation::class);

        $res = $provider->provide($operation, ['id' => $id]);

        $this->assertSame($dto, $res);
    }

    public function testProvideOneThrowsNotFound()
    {
        $id = 1;

        /** @var \PHPUnit\Framework\MockObject\MockObject&\App\Repository\ContentTypeRepository $repository */
        $repository = $this->createMock(ContentTypeRepository::class);
        $repository->method('findOneBy')->willReturn(null);

        /** @var \PHPUnit\Framework\MockObject\MockObject&\App\Api\V1\Mapper\Courses\ContentType\ContentTypeMapper $mapper */
        $mapper = $this->createMock(ContentTypeMapper::class);

        $provider = new ContentTypeProvider($repository, $mapper);

        /** @var \PHPUnit\Framework\MockObject\MockObject&\ApiPlatform\Metadata\Operation $operation */
        $operation = $this->createMock(Operation::class);

        $this->expectException(NotFoundHttpException::class);
        $provider->provide($operation, ['id' => $id]);
    }

    public function testProvideAllReturnsMappedArray()
    {

        $id_1 = 1;
        $name_1 = 'Title';

        $id_2 = 2;
        $name_2 = 'Paragraph';

        $dto1 = new ContentTypeOutput(
            $id_1,
            $name_1
        );

        $dto2 = new ContentTypeOutput(
            $id_2,
            $name_2
        );

        $dtoArray = [$dto1, $dto2];

        $contentType1 = $this->createMock(ContentType::class);
        $contentType2 = $this->createMock(ContentType::class);
        $entityArray = [$contentType1, $contentType2];

        /** @var \PHPUnit\Framework\MockObject\MockObject&\App\Repository\ContentTypeRepository $repository */
        $repository = $this->createMock(ContentTypeRepository::class);
        $repository
            ->method('findAll')
            ->willReturn($entityArray)
        ;

        /** @var \PHPUnit\Framework\MockObject\MockObject&\App\Api\V1\Mapper\Courses\ContentType\ContentTypeMapper $mapper */
        $mapper = $this->createMock(ContentTypeMapper::class);
        $mapper->expects($this->once())
            ->method('fromArray')
            ->with($entityArray)
            ->willReturn($dtoArray);

        $provider = new ContentTypeProvider(
            $repository,
            $mapper
        );

        $operation = new GetCollection();

        $res = $provider->provide(
            $operation,
            [],
        );

        $this->assertSame($dtoArray, $res);
    }
}
