<?php

namespace App\Api\V1\Services;

interface PreparerInterface {
    public function prepare(mixed $input): mixed;
}