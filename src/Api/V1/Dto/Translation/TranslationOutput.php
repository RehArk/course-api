<?php

namespace App\Api\V1\Dto\Translation;

class TranslationOutput
{
    public string $local;
    public string $text;

    public function __construct(
        string $local,
        string $text
    ){
        $this->local = $local;
        $this->text = $text;
    }
}
