<?php

namespace App\Tests\Api\V1\Services\Courses\ContentType;

use App\Api\V1\Dto\Courses\ContentType\ContentTypeInput;
use App\Api\V1\Dto\Courses\ContentType\PreparedContentTypeInput;
use App\Api\V1\Services\Courses\ContentType\ContentTypePreparer;
use PHPUnit\Framework\TestCase;

class ContentTypePreparerTest extends TestCase
{

    public function testPrepare()
    {

        $name = 'Title';

        $contentInput = new ContentTypeInput();
        $contentInput->name = $name;

        $contentPreparer = new ContentTypePreparer();

        $res = $contentPreparer->prepare(
            $contentInput
        );

        $this->assertEquals($res, new PreparedContentTypeInput(
            $name
        ));
    }

}
