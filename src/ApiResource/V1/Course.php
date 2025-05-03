<?php

namespace App\ApiResource\V1;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use App\Api\V1\Dto\Course\CourseInput;
use App\Api\V1\Dto\Course\CourseOutput;
use App\Api\V1\State\Course\CourseProcessor;
use App\Api\V1\State\Course\CourseProvider;
use App\Entity\Translation;
use DateTime;

#[ApiResource(
    routePrefix: '/v1',
    operations: [
        new Get(
            uriTemplate: '/courses/{id}',
            output: CourseOutput::class,
            provider: CourseProvider::class,
            name: 'get_course_by_id'
        ),
        new Post(
            input: CourseInput::class,
            output: CourseOutput::class,
            processor: CourseProcessor::class,
            name: 'create_course'
        )
    ]
)]
class Course
{
    public string $id;
    public Translation $translation;
    public DateTime $createdAt;
    public DateTime $updatedAt;
}
