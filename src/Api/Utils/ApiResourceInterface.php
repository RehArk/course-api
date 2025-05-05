<?php

namespace App\Api\Utils;

interface ApiResourceInterface  {
    public static function getEntityClass() : string;
}