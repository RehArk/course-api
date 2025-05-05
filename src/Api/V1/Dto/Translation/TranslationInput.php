<?php

namespace App\Api\V1\Dto\Translation;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class TranslationInput
{
    #[NotNull()]
    #[NotBlank()]
    public string $local;
    
    #[NotNull()]
    #[NotBlank(['normalizer' => 'trim'])]
    public string $text;
}
