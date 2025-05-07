<?php

namespace App\Tests\Api\V1\Services\Courses\Course;

use App\Api\V1\Dto\Courses\Course\CourseInput;
use App\Api\V1\Dto\Courses\Course\PreparedCourseInput;
use App\Api\V1\Services\Courses\Course\CoursePreparer;
use PHPUnit\Framework\TestCase;

class CoursePreparerTest extends TestCase
{

    public function testPrepare()
    {

        $title = 'Title';

        $contentInput = new CourseInput();
        $contentInput->default_title = $title;

        $contentPreparer = new CoursePreparer();

        $res = $contentPreparer->prepare(
            $contentInput
        );

        $this->assertEquals($res, new PreparedCourseInput(
            $title
        ));
    }

}
