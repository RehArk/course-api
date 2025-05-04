<?php

namespace App\Tests\Dto\Courses\Chapter;

use App\Api\V1\Dto\Courses\Chapter\ChapterInput;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ChapterInputTest extends KernelTestCase
{
    private ValidatorInterface $validator;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->validator = static::getContainer()->get(ValidatorInterface::class);
    }

    private function getErrors(ChapterInput $input): ConstraintViolationList
    {
        return $this->validator->validate($input);
    }

    public function testValidInput(): void
    {
        $input = new ChapterInput();
        $input->course_id = '123e4567-e89b-12d3-a456-426614174000';
        $input->default_title = 'Chapitre Un';

        $errors = $this->getErrors($input);
        $this->assertCount(0, $errors);
    }

    public function testCourseIdIsInvalidUuid(): void
    {
        $input = new ChapterInput();
        $input->course_id = 'not-a-uuid';
        $input->default_title = 'Chapitre Un';

        $errors = $this->getErrors($input);
        $this->assertGreaterThan(0, count($errors));
    }

    public function testTitleTooShort(): void
    {
        $input = new ChapterInput();
        $input->course_id = '123e4567-e89b-12d3-a456-426614174000';
        $input->default_title = 'Hi';

        $errors = $this->getErrors($input);
        $this->assertGreaterThan(0, count($errors));
    }

    public function testTitleTooLong(): void
    {
        $input = new ChapterInput();
        $input->course_id = '123e4567-e89b-12d3-a456-426614174000';
        $input->default_title = str_repeat('a', 101);

        $errors = $this->getErrors($input);
        $this->assertGreaterThan(0, count($errors));
    }

    public function testTitleWithInvalidCharacters(): void
    {
        $input = new ChapterInput();
        $input->course_id = '123e4567-e89b-12d3-a456-426614174000';
        $input->default_title = 'Chapitre 1 !';

        $errors = $this->getErrors($input);
        $this->assertGreaterThan(0, count($errors));
    }

}