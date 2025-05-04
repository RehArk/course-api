<?php

namespace App\Tests\Dto\Courses\Content;

use App\Api\V1\Dto\Courses\Content\ContentInput;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ContentInputTest extends KernelTestCase
{
    private ValidatorInterface $validator;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->validator = static::getContainer()->get(ValidatorInterface::class);
    }

    private function getErrors(ContentInput $input): ConstraintViolationList
    {
        return $this->validator->validate($input);
    }

    public function testValidInput(): void
    {
        $input = new ContentInput();
        $input->chapter_id = '123e4567-e89b-12d3-a456-426614174000';
        $input->parent_id = '223e4567-e89b-12d3-a456-426614174000';
        $input->content_type_id = 1;
        $input->default_content = 'Contenu du chapitre';

        $errors = $this->getErrors($input);
        $this->assertCount(0, $errors);
    }

    public function testInvalidChapterId(): void
    {
        $input = new ContentInput();
        $input->chapter_id = 'invalid-uuid';
        $input->parent_id = '223e4567-e89b-12d3-a456-426614174000';
        $input->content_type_id = 1;
        $input->default_content = 'Contenu du chapitre';

        $errors = $this->getErrors($input);
        $this->assertGreaterThan(0, count($errors));
    }

    public function testInvalidParentId(): void
    {
        $input = new ContentInput();
        $input->chapter_id = '123e4567-e89b-12d3-a456-426614174000';
        $input->parent_id = 'not-a-uuid';
        $input->content_type_id = 1;
        $input->default_content = 'Contenu du chapitre';

        $errors = $this->getErrors($input);
        $this->assertGreaterThan(0, count($errors));
    }

    public function testNegativeContentTypeId(): void
    {
        $input = new ContentInput();
        $input->chapter_id = '123e4567-e89b-12d3-a456-426614174000';
        $input->parent_id = null;
        $input->content_type_id = -5;
        $input->default_content = 'Contenu du chapitre';

        $errors = $this->getErrors($input);
        $this->assertGreaterThan(0, count($errors));
    }

    public function testNonIntegerContentTypeId(): void
    {
        $this->expectException(\TypeError::class);

        $input = new ContentInput();
        $input->chapter_id = '123e4567-e89b-12d3-a456-426614174000';
        $input->parent_id = null;
        $input->content_type_id = 'string';
        $input->default_content = 'Contenu du chapitre';

        $this->getErrors($input);
    }

    public function testEmptyDefaultContent(): void
    {
        $input = new ContentInput();
        $input->chapter_id = '123e4567-e89b-12d3-a456-426614174000';
        $input->parent_id = null;
        $input->content_type_id = 2;
        $input->default_content = '     ';

        $errors = $this->getErrors($input);
        $this->assertGreaterThan(0, count($errors));
    }
}