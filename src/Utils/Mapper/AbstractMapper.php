<?php

namespace App\Utils\Mapper;

abstract class AbstractMapper {

    public function fromArray(
        array $entities
    ) {
        return array_map([$this, 'fromEntity'], $entities);
    }

    abstract public function fromEntity(mixed $entity): mixed;

}