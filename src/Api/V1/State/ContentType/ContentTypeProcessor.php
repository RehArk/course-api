<?php

namespace App\Api\V1\State\ContentType;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Api\V1\Dto\ContentType\ContentTypeOutput;
use App\Api\V1\Mapper\ContentType\ContentTypeMapper;
use App\Entity\ContentType;
use Doctrine\ORM\EntityManagerInterface;

class ContentTypeProcessor implements ProcessorInterface {
 
    private EntityManagerInterface $em;

    public function __construct(
        EntityManagerInterface $em
    ) {
        $this->em = $em;
    }

    public function process(
        mixed $data,
        Operation $operation,
        array $uriVariables = [],
        array $context = []
    ) {
        
        $contentType = new ContentType();
        $contentType->setName($data->name);

        $this->em->persist($contentType);
        $this->em->flush();

        return ContentTypeMapper::fromEntity($contentType);
    }

}