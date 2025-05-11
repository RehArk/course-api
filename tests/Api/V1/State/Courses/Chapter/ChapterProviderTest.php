<?php

namespace App\Tests\Api\V1\State\Courses\Chapter;

use App\Api\V1\State\Courses\Chapter\ChapterProvider;
use App\Api\V1\Mapper\Courses\Chapter\ChapterMapper;
use App\Entity\Chapter;
use App\Repository\ChapterRepository;
use ApiPlatform\Metadata\Operation;
use App\ApiResource\V1\Chapter as ApiChapter;
use DateTime;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ChapterProviderTest extends TestCase
{
    public function testProvideReturnsMappedChapter()
    {
        $id = '1';
        $dto = new ApiChapter(
            $id,
            '1',
            null,
            null,
            'test',
            new DateTime(),
            new DateTime()
        );

        $chapter = $this->createMock(Chapter::class);

        /** @var \PHPUnit\Framework\MockObject\MockObject&\App\Repository\ChapterRepository $repository */
        $repository = $this->createMock(ChapterRepository::class);
        $repository->method('findOneBy')
            ->with(['id' => $id])
            ->willReturn($chapter);

        /** @var \PHPUnit\Framework\MockObject\MockObject&\App\Api\V1\Mapper\Courses\Chapter\ChapterMapper $mapper */
        $mapper = $this->createMock(ChapterMapper::class);
        $mapper->expects($this->once())
            ->method('fromEntity')
            ->with($chapter)
            ->willReturn($dto);

        $provider = new ChapterProvider($repository, $mapper);

        /** @var \PHPUnit\Framework\MockObject\MockObject&\ApiPlatform\Metadata\Operation $operation */
        $operation = $this->createMock(Operation::class);

        $result = $provider->provide($operation, ['id' => $id]);

        $this->assertSame($dto, $result);
    }

    public function testProvideThrowsNotFoundWhenChapterMissing()
    {
        $id = '1';

        /** @var \PHPUnit\Framework\MockObject\MockObject&\App\Repository\ChapterRepository $repository */
        $repository = $this->createMock(ChapterRepository::class);
        $repository->method('findOneBy')->with(['id' => $id])->willReturn(null);

        /** @var \PHPUnit\Framework\MockObject\MockObject&\App\Api\V1\Mapper\Courses\Chapter\ChapterMapper $mapper */
        $mapper = $this->createMock(ChapterMapper::class);

        $provider = new ChapterProvider($repository, $mapper);

        /** @var \PHPUnit\Framework\MockObject\MockObject&\ApiPlatform\Metadata\Operation $operation */
        $operation = $this->createMock(Operation::class);

        $this->expectException(NotFoundHttpException::class);

        $provider->provide($operation, ['id' => $id]);
    }
}
