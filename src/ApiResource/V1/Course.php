<?php

namespace App\ApiResource\V1;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use App\Api\Utils\ApiResourceInterface;
use App\Api\V1\Dto\Courses\Course\CourseInput;
use App\Api\V1\Dto\Translation\TranslationInput;
use App\Api\V1\State\Courses\Course\CourseProcessor;
use App\Api\V1\State\Courses\Course\CourseProvider;
use App\Api\V1\State\Translation\TranslationProcessor;
use App\Entity\Course as EntityCourse;
use DateTime;

#[ApiResource(
    routePrefix: '/v1',
    operations: [
        new Get(
            provider: CourseProvider::class,
            name: 'get_course_by_id'
        ),
        new Post(
            input: CourseInput::class,
            processor: CourseProcessor::class,
            name: 'create_course'
        ),
        new Post(
            uriTemplate: '/courses/{id}/translation',
            controller: null,
            processor: TranslationProcessor::class,
            input: TranslationInput::class,
            name: 'create_or_update_course_translation'
        )
    ]
)]
class Course implements ApiResourceInterface
{
    public string $id;
    public string $title;
    public \DateTime $createdAt;
    public \DateTime $updatedAt;

    public function __construct(
        string $id,
        string $title,
        DateTime $createdAt,
        DateTime $updatedAt
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public static function getEntityClass() : string {
        return EntityCourse::class;
    }

}
