<?php

namespace App\Utils\Translation;

use App\Entity\Translation;

interface TranslatableEntityInterface {
    public function getTranslation(): Translation;
}