<?php

namespace App\Api\V1\Dto\Courses\ContentType;

class ContentTypeOutput {
    
    public int $id;
    public string $name;

    public function __construct(
        int $id,
        string $name
    ) {
        $this->id = $id;
        $this->name = $name;
    }
}