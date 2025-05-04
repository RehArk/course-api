<?php

namespace App\Api\V1\State\Courses\ContentType;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Api\V1\Mapper\Courses\ContentType\ContentTypeMapper;
use App\Api\V1\Services\Courses\ContentType\ContentTypePreparer;
use App\Entity\ContentType;
use Doctrine\ORM\EntityManagerInterface;

class ContentTypeProcessor implements ProcessorInterface
{

    private EntityManagerInterface $em;
    private ContentTypePreparer $preparer;


    public function __construct(
        EntityManagerInterface $em,
        ContentTypePreparer $preparer

    ) {
        $this->em = $em;
        $this->preparer = $preparer;
    }

    /**
     * Handles the state.
     *
     * @param T1                                                                                                                        $data
     * @param array<string, mixed>                                                                                                      $uriVariables
     * @param array<string, mixed>&array{request?: Request, previous_data?: mixed, resource_class?: string|null, original_data?: mixed} $context
     *
     * @return T2
     */
    public function process(
        mixed $data,
        Operation $operation,
        array $uriVariables = [],
        array $context = []
    ) {

        /** @var \App\Api\V1\Dto\Courses\ContentType\PreparedContentTypeInput */
        $preparedInput = $this->preparer->prepare($data);

        $contentType = new ContentType();
        $contentType->setName($preparedInput->name);

        $this->em->persist($contentType);
        $this->em->flush();

        return ContentTypeMapper::fromEntity($contentType);
    }
}
