<?php

namespace App\Api\V1\State\Courses\Chapter;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Api\V1\Mapper\Courses\Chapter\ChapterMapper;
use App\Repository\ChapterRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ChapterProvider implements ProviderInterface {

    private ChapterRepository $repository;
    private ChapterMapper $mapper;

    public function __construct(
        ChapterRepository $repository,
        ChapterMapper $mapper
    ) {
        $this->repository = $repository;
        $this->mapper = $mapper;
    }

    public function provide(
        Operation $operation,
        array $uriVariables = [],
        array $context = []
    ): object|array|null {

        /** @var \App\Entity\Chapter */
        $chapter = $this->repository->findOneBy(['id' => $uriVariables['id']]);
        
        if(!$chapter) {
            throw new NotFoundHttpException();
        }

        return $this->mapper->fromEntity($chapter);
    }
}