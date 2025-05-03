<?php

namespace App\Api\V1\State\ContentType;

use ApiPlatform\Metadata\CollectionOperationInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Api\V1\Mapper\ContentType\ContentTypeMapper;
use App\Repository\ContentTypeRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ContentTypeProvider implements ProviderInterface {

    private ContentTypeRepository $repository;

    public function __construct(
        ContentTypeRepository $repository
    ) {
        $this->repository = $repository;
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

    private function provideAll() {
        /** @var array<\App\Entity\ContentType> */
        $contentTypes = $contentType = $this->repository->findAll();
        return ContentTypeMapper::fromArray($contentTypes);
    }

    private function provideOne(
        string $id
    ) {
        /** @var \App\Entity\ContentType */
        $contentType = $this->repository->findOneBy(['id' => $id]);
                
        if(!$contentType) {
            throw new NotFoundHttpException();
        }

        return ContentTypeMapper::fromEntity($contentType);
    }

}