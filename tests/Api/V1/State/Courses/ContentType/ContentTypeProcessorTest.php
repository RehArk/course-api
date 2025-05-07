<?php

namespace App\Tests\Api\V1\State\Courses\ContentType;

use ApiPlatform\Metadata\Operation;
use App\Api\V1\Dto\Courses\ContentType\ContentTypeInput;
use App\Api\V1\Dto\Courses\ContentType\ContentTypeOutput;
use App\Api\V1\Dto\Courses\ContentType\PreparedContentTypeInput;
use App\Api\V1\Mapper\Courses\ContentType\ContentTypeMapper;
use App\Api\V1\Services\Courses\ContentType\ContentTypePreparer;
use App\Api\V1\State\Courses\ContentType\ContentTypeProcessor;
use App\Entity\ContentType;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class ContentTypeProcessorTest extends TestCase
{

    public function testProcess()
    {
        $name = 'Title';

        $contentTypeInput = new ContentTypeInput();
        $contentTypeInput->name = $name;

        $preparedContentTypeInput = new PreparedContentTypeInput(
            $contentTypeInput->name
        );

        $contentTypeOutput = new ContentTypeOutput(
            '1',
            $contentTypeInput->name
        );

        /** @var \PHPUnit\Framework\MockObject\MockObject&\Doctrine\ORM\EntityManagerInterface $em */
        $em = $this->createMock(EntityManagerInterface::class);
        $em
            ->expects($this->once())
            ->method('persist')
        ;
        $em
            ->expects($this->once())
            ->method('flush')
        ;

        /** @var \PHPUnit\Framework\MockObject\MockObject&\App\Api\V1\Services\Courses\ContentType\ContentTypePreparer $contentTypePreparer */
        $contentTypePreparer = $this->createMock(ContentTypePreparer::class);
        $contentTypePreparer
            ->expects($this->once())
            ->method('prepare')
            ->willReturn($preparedContentTypeInput)
        ;

        /** @var \PHPUnit\Framework\MockObject\MockObject&\App\Api\V1\Mapper\Courses\ContentType\ContentTypeMapper $mapper */
        $mapper = $this->createMock(ContentTypeMapper::class);
        $mapper
            ->method('fromEntity')
            ->willReturn($contentTypeOutput)
        ;

        $contentTypeProcessor = new ContentTypeProcessor(
            $em,
            $contentTypePreparer,
            $mapper
        );

        /** @var \PHPUnit\Framework\MockObject\MockObject&\ApiPlatform\Metadata\Operation $operation */
        $operation = $this->createMock(Operation::class);

        $uriVariables = [];
        $context = [];

        $res = $contentTypeProcessor->process(
            $contentTypeInput,
            $operation,
            $uriVariables,
            $context
        );

        $this->assertEquals($res, $contentTypeOutput);
    }
}
