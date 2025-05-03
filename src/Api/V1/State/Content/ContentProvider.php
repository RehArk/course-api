<?php

namespace App\Api\V1\State\Content;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Api\V1\Mapper\Content\ContentMapper;
use App\Repository\ContentRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ContentProvider implements ProviderInterface {
    
    private ContentRepository $repository;

    public function __construct(
        ContentRepository $repository
    ) {
        $this->repository = $repository;    
    }

    public function provide(
        Operation $operation,
        array $uriVariables = [],
        array $context = []
    ) : object|array|null {

        $content = $this->repository->findOneBy(['id' => $uriVariables['id']]);

        if(!$content) {
            throw new NotFoundHttpException();
        }

        return ContentMapper::fromEntity($content);
    }

}