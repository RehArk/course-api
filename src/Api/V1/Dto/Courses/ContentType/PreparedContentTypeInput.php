<?php

namespace App\Api\V1\Dto\Courses\ContentType;

class PreparedContentTypeInput {

    public string $name;

    public function __construct(
      string $name
    ) {
      $this->name = $name;  
    }
    
}