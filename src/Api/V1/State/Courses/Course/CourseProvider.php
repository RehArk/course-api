<?php

namespace App\Api\V1\State\Courses\Course;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Api\V1\Mapper\Courses\Course\CourseMapper;
use App\Repository\CourseRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CourseProvider implements ProviderInterface
{

    private CourseRepository $repository;
    private CourseMapper $mapper;

    public function __construct(
        CourseRepository $repository,
        CourseMapper $mapper,
    ) {
        $this->repository = $repository;
        $this->mapper = $mapper;
    }

    public function provide(
        Operation $operation,
        array $uriVariables = [],
        array $context = []
    ): object|array|null {

        /** @var \App\Entity\Course */
        $course = $this->repository->findOneBy(['id' => $uriVariables['id']]);

        if (!$course) {
            throw new NotFoundHttpException();
        }

        return $this->mapper->fromEntity($course);
    }
}
