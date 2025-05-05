<?php

namespace App\Api\V1\Dto\Translation;

use App\Entity\Language;

class PreparedTranslationInput
{
    public Language $language;
    public string $text;

    public function __construct(
        Language $language,
        string $text
    ) {
        $this->language = $language;
        $this->text = $text;
    }
}
