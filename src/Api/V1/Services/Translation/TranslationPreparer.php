<?php

namespace App\Api\V1\Services\Translation;

use App\Api\V1\Dto\Translation\PreparedTranslationInput;
use App\Api\V1\Services\PreparerInterface;
use App\Repository\LanguageRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TranslationPreparer implements PreparerInterface
{

    private LanguageRepository $languageRepository;

    public function __construct(
        LanguageRepository $languageRepository
    ) {
        $this->languageRepository = $languageRepository;
    }

    public function prepare(mixed $input): mixed
    {
        /** @var \App\Entity\Language */
        $language = $this->languageRepository->findOneBy(['code' => $input->local]);

        if (!$language) {
            throw new NotFoundHttpException('Unsupported language');
        }

        return new PreparedTranslationInput(
            $language,
            $input->text
        );
    }
}
