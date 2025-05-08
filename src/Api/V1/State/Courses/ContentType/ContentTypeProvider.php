<?php

namespace App\Api\V1\State\Courses\ContentType;

use ApiPlatform\Metadata\CollectionOperationInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Api\V1\Mapper\Courses\ContentType\ContentTypeMapper;
use App\Repository\ContentTypeRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ContentTypeProvider implements ProviderInterface
{

    private ContentTypeRepository $repository;
    private ContentTypeMapper $mapper;

    public function __construct(
        ContentTypeRepository $repository,
        ContentTypeMapper $mapper
    ) {
        $this->repository = $repository;
        $this->mapper = $mapper;
    }

    public function provide(
        Operation $operation,
        array $uriVariables = [],
        array $context = []
    ): object|array|null {
        
        if ($operation instanceof CollectionOperationInterface) {
            return $this->provideAll();
        }

        return $this->provideOne($uriVariables['id']);
    }

    private function provideAll()
    {
        /** @var array<\App\Entity\ContentType> */
        $contentTypes = $this->repository->findAll();
        return $this->mapper->fromArray($contentTypes);
    }

    private function provideOne(
        string $id
    ) {
        /** @var \App\Entity\ContentType */
        $contentType = $this->repository->findOneBy(['id' => $id]);

        if (!$contentType) {
            throw new NotFoundHttpException();
        }

        return $this->mapper->fromEntity($contentType);
    }
}
