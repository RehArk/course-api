<?php

namespace App\Api\V1\Dto\ContentType;

class ContentTypeOutput {
    
    public string $id;
    public string $name;

    public function __construct(
        string $id,
        string $name
    ) {
        $this->id = $id;
        $this->name = $name;
    }
}