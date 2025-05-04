<?php

namespace App\Tests\Dto\Courses\ContentType;

use App\Api\V1\Dto\Courses\ContentType\ContentTypeInput;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\ConstraintViolationList;

class ContentTypeInputTest extends KernelTestCase
{
    private ValidatorInterface $validator;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->validator = static::getContainer()->get(ValidatorInterface::class);
    }

    private function getErrors(ContentTypeInput $input): ConstraintViolationList
    {
        return $this->validator->validate($input);
    }

    public function testValidName(): void
    {
        $input = new ContentTypeInput();
        $input->name = 'Type de contenu';

        $errors = $this->getErrors($input);
        $this->assertCount(0, $errors);
    }

    public function testTooShortName(): void
    {
        $input = new ContentTypeInput();
        $input->name = 'Hi';

        $errors = $this->getErrors($input);
        $this->assertGreaterThan(0, count($errors));
    }

    public function testTooLongName(): void
    {
        $input = new ContentTypeInput();
        $input->name = str_repeat('a', 101);

        $errors = $this->getErrors($input);
        $this->assertGreaterThan(0, count($errors));
    }

    public function testNameWithInvalidCharacters(): void
    {
        $input = new ContentTypeInput();
        $input->name = 'Type 123!';

        $errors = $this->getErrors($input);
        $this->assertGreaterThan(0, count($errors));
    }
}