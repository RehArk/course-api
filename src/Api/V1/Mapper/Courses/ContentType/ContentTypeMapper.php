<?php

namespace App\Api\V1\Mapper\Courses\ContentType;

use App\Api\V1\Dto\Courses\ContentType\ContentTypeOutput;
use App\Entity\ContentType;

class ContentTypeMapper {

    public function fromArray(
        array $contentTypes
    ) {
        return array_map([self::class, 'fromEntity'], $contentTypes);
    }

    public function fromEntity(
        ContentType $contentType
    ) : ContentTypeOutput {
        return new ContentTypeOutput(
            $contentType->getId(),
            $contentType->getName()
        );
    }
}