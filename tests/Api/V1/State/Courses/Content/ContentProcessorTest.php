<?php

namespace App\Tests\Api\V1\State\Courses\Content;

use ApiPlatform\Metadata\Operation;
use App\Api\V1\Dto\Courses\Content\ContentInput;
use App\Api\V1\Dto\Courses\Content\ContentOutput;
use App\Api\V1\Dto\Courses\Content\PreparedContentInput;
use App\Api\V1\Mapper\Courses\Content\ContentMapper;
use App\Api\V1\Services\Courses\Content\ContentPreparer;
use App\Api\V1\State\Courses\Content\ContentProcessor;
use App\Entity\Chapter;
use App\Entity\ContentType;
use App\Entity\Translation;
use App\Factory\TranslationFactory;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class ContentProcessorTest extends TestCase
{

    public function testProcess()
    {
        $chapter_id = '1';
        $parent_id = null;
        $content_type_id = 1;
        $default_content = 'Chapter 1';

        $contentInput = new ContentInput();
        $contentInput->chapter_id = $chapter_id;
        $contentInput->parent_id = $parent_id;
        $contentInput->content_type_id = $content_type_id;
        $contentInput->default_content = $default_content;

        /** @var \PHPUnit\Framework\MockObject\MockObject&\App\Entity\Chapter $chapter */
        $chapter = $this->createMock(Chapter::class);
        $chapter
            ->method('getId')
            ->willReturn($contentInput->chapter_id)
        ;

        $parentContent = null;
        $previousContent = null;

        /** @var \PHPUnit\Framework\MockObject\MockObject&\App\Entity\ContentType $contentType */
        $contentType = $this->createMock(ContentType::class);
        $contentType
            ->method('getId')
            ->willReturn($contentInput->content_type_id)
        ;
        
        $preparedContentInput = new PreparedContentInput(
            $chapter,
            $parentContent,
            $previousContent,
            $contentType,
            $contentInput->default_content
        );

        $contentOutput = new ContentOutput(
            '1',
            '1',
            null,
            null,
            null,
            1,
            $default_content,
            new DateTime(),
            new DateTime()
        );

        $translation = $this->createMock(Translation::class);

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

        /** @var \PHPUnit\Framework\MockObject\MockObject&\App\Api\V1\Services\Courses\Content\ContentPreparer $contentPreparer */
        $contentPreparer = $this->createMock(ContentPreparer::class);
        $contentPreparer
            ->expects($this->once())
            ->method('prepare')
            ->willReturn($preparedContentInput)
        ;

        /** @var \PHPUnit\Framework\MockObject\MockObject&\App\Factory\TranslationFactory $translationFactory */
        $translationFactory = $this->createMock(TranslationFactory::class);
        $translationFactory
            ->expects($this->once())
            ->method('createWithDefaultEnglishText')
            ->willReturn($translation)
        ;

        /** @var \PHPUnit\Framework\MockObject\MockObject&\App\Api\V1\Mapper\Courses\Content\ContentMapper $mapper */
        $mapper = $this->createMock(ContentMapper::class);
        $mapper
            ->method('fromEntity')
            ->willReturn($contentOutput)
        ;

        $contentProcessor = new ContentProcessor(
            $em,
            $contentPreparer,
            $translationFactory,
            $mapper
        );

        /** @var \PHPUnit\Framework\MockObject\MockObject&\ApiPlatform\Metadata\Operation $operation */
        $operation = $this->createMock(Operation::class);

        $uriVariables = [];
        $context = [];

        $res = $contentProcessor->process(
            $contentInput,
            $operation,
            $uriVariables,
            $context
        );

        $this->assertEquals($res, $contentOutput);
    }
}
