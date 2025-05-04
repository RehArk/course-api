<?php

namespace App\Api\V1\Services\Courses\ContentType;

use App\Api\V1\Dto\Courses\ContentType\PreparedContentTypeInput;
use App\Api\V1\Services\PreparerInterface;

class ContentTypePreparer implements PreparerInterface {

    public function prepare(mixed $input): mixed
    {
        return new PreparedContentTypeInput($input->name);
    }

}