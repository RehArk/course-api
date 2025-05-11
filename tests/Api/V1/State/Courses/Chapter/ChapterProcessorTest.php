<?php

namespace App\Tests\Api\V1\State\Courses\Chapter;

use ApiPlatform\Metadata\Operation;
use App\Api\V1\Dto\Courses\Chapter\ChapterInput;
use App\Api\V1\Dto\Courses\Chapter\PreparedChapterInput;
use App\Api\V1\Mapper\Courses\Chapter\ChapterMapper;
use App\Api\V1\Services\Courses\Chapter\ChapterPreparer;
use App\Api\V1\State\Courses\Chapter\ChapterProcessor;
use App\ApiResource\V1\Chapter as ApiChapter;
use App\Entity\Course;
use App\Entity\Translation;
use App\Factory\TranslationFactory;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class ChapterProcessorTest extends TestCase
{

    public function testProcess()
    {
        $title = 'Chapter 1';

        $chapterInput = new ChapterInput();
        $chapterInput->default_title = $title;

        /** @var \PHPUnit\Framework\MockObject\MockObject&\App\Entity\Course $course */
        $course = $this->createMock(Course::class);

        $previousChapter = null;
        // /** @var \PHPUnit\Framework\MockObject\MockObject&\App\Entity\Chapter $previousChapter */
        // $previousChapter = $this->createMock(Chapter::class);

        $preparedChapterInput = new PreparedChapterInput(
            $course,
            $previousChapter,
            $chapterInput->default_title
        );

        $chapterOutput = new ApiChapter(
            '1',
            '1',
            null,
            null,
            $title,
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

        /** @var \PHPUnit\Framework\MockObject\MockObject&\App\Api\V1\Services\Courses\Chapter\ChapterPreparer $chapterPreparer */
        $chapterPreparer = $this->createMock(ChapterPreparer::class);
        $chapterPreparer
            ->expects($this->once())
            ->method('prepare')
            ->willReturn($preparedChapterInput)
        ;

        /** @var \PHPUnit\Framework\MockObject\MockObject&\App\Factory\TranslationFactory $translationFactory */
        $translationFactory = $this->createMock(TranslationFactory::class);
        $translationFactory
            ->expects($this->once())
            ->method('createWithDefaultEnglishText')
            ->willReturn($translation)
        ;

        /** @var \PHPUnit\Framework\MockObject\MockObject&\App\Api\V1\Mapper\Courses\Chapter\ChapterMapper $mapper */
        $mapper = $this->createMock(ChapterMapper::class);
        $mapper
            ->method('fromEntity')
            ->willReturn($chapterOutput)
        ;

        $chapterProcessor = new ChapterProcessor(
            $em,
            $chapterPreparer,
            $translationFactory,
            $mapper
        );

        /** @var \PHPUnit\Framework\MockObject\MockObject&\ApiPlatform\Metadata\Operation $operation */
        $operation = $this->createMock(Operation::class);

        $uriVariables = [];
        $context = [];

        $res = $chapterProcessor->process(
            $chapterInput,
            $operation,
            $uriVariables,
            $context
        );

        $this->assertEquals($res, $chapterOutput);
    }
}
