<?php

namespace App\Api\V1\Mapper\Courses\ContentType;

use App\ApiResource\V1\ContentType as ApiContentType;
use App\Entity\ContentType;
use App\Utils\Mapper\AbstractMapper;

class ContentTypeMapper extends AbstractMapper
{

    /**
     * @param ContentType $entity
     * 
     * @return ApiContentType
     */
    public function fromEntity(
        mixed $contentType
    ): mixed {

        return new ApiContentType(
            $contentType->getId(),
            $contentType->getName()
        );
    }
}
