<?php

namespace App\Tests\Dto\Courses\Course;

use App\Api\V1\Dto\Courses\Course\CourseInput;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\ConstraintViolationList;

class CourseInputTest extends KernelTestCase
{
    private ValidatorInterface $validator;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->validator = static::getContainer()->get(ValidatorInterface::class);
    }

    private function getErrors(CourseInput $input): ConstraintViolationList
    {
        return $this->validator->validate($input);
    }

    public function testValidTitle(): void
    {
        $input = new CourseInput();
        $input->default_title = 'Titre de cours';

        $errors = $this->getErrors($input);
        $this->assertCount(0, $errors);
    }

    public function testTooShortTitle(): void
    {
        $input = new CourseInput();
        $input->default_title = 'Hi';

        $errors = $this->getErrors($input);
        $this->assertGreaterThan(0, count($errors));
    }

    public function testTooLongTitle(): void
    {
        $input = new CourseInput();
        $input->default_title = str_repeat('a', 101);

        $errors = $this->getErrors($input);
        $this->assertGreaterThan(0, count($errors));
    }

    public function testTitleWithInvalidCharacters(): void
    {
        $input = new CourseInput();
        $input->default_title = 'Cours 101!';

        $errors = $this->getErrors($input);
        $this->assertGreaterThan(0, count($errors));
    }
}