<?php

namespace App\Tests\Api\V1\State\Courses\Course;

use ApiPlatform\Metadata\Operation;
use App\Api\V1\Dto\Courses\Course\CourseInput;
use App\Api\V1\Dto\Courses\Course\CourseOutput;
use App\Api\V1\Dto\Courses\Course\PreparedCourseInput;
use App\Api\V1\Mapper\Courses\Course\CourseMapper;
use App\Api\V1\Services\Courses\Course\CoursePreparer;
use App\Api\V1\State\Courses\Course\CourseProcessor;
use App\Entity\Translation;
use App\Factory\TranslationFactory;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class CourseProcessorTest extends TestCase
{

    public function testProcess()
    {
        $default_title = 'Title';

        $courseInput = new CourseInput();
        $courseInput->default_title = $default_title;

        $preparedCourseInput = new PreparedCourseInput(
            $courseInput->default_title
        );

        $courseOutput = new CourseOutput(
            '1',
            $courseInput->default_title,
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

        /** @var \PHPUnit\Framework\MockObject\MockObject&\App\Api\V1\Services\Courses\Course\CoursePreparer $coursePreparer */
        $coursePreparer = $this->createMock(CoursePreparer::class);
        $coursePreparer
            ->expects($this->once())
            ->method('prepare')
            ->willReturn($preparedCourseInput)
        ;

        /** @var \PHPUnit\Framework\MockObject\MockObject&\App\Factory\TranslationFactory $translationFactory */
        $translationFactory = $this->createMock(TranslationFactory::class);
        $translationFactory
            ->expects($this->once())
            ->method('createWithDefaultEnglishText')
            ->willReturn($translation)
        ;

        /** @var \PHPUnit\Framework\MockObject\MockObject&\App\Api\V1\Mapper\Courses\Course\CourseMapper $mapper */
        $mapper = $this->createMock(CourseMapper::class);
        $mapper
            ->method('fromEntity')
            ->willReturn($courseOutput)
        ;

        $courseProcessor = new CourseProcessor(
            $em,
            $coursePreparer,
            $translationFactory,
            $mapper
        );

        /** @var \PHPUnit\Framework\MockObject\MockObject&\ApiPlatform\Metadata\Operation $operation */
        $operation = $this->createMock(Operation::class);

        $uriVariables = [];
        $context = [];

        $res = $courseProcessor->process(
            $courseInput,
            $operation,
            $uriVariables,
            $context
        );

        $this->assertEquals($res, $courseOutput);
    }
}
