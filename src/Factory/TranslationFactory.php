<?php

namespace App\Factory;

use App\Entity\Language;
use App\Entity\Translation;
use App\Entity\TranslationText;
use App\Repository\LanguageRepository;
use Doctrine\ORM\EntityManagerInterface;

class TranslationFactory
{
    public function __construct(
        private LanguageRepository $languageRepository,
        private EntityManagerInterface $em,
    ) {}

    public function createWithDefaultEnglishText(string $text): Translation
    {
        $language = $this->languageRepository->findOneBy(['code' => 'en']);

        if (!$language) {
            $language = new Language();
            $language->setCode('en')->setName('english');
            $this->em->persist($language);
        }

        $translationText = new TranslationText();
        $translationText
            ->setLanguage($language)
            ->setText($text);

        $translation = new Translation();
        $translation->addTranslationText($translationText);

        return $translation;
    }

    public function findOrCreate(
        Translation $translation,
        Language $language
    ): TranslationText {

        $translationText = $translation->getTranslationText($language->getCode());

        if($translationText) {
            return $translationText;
        }

        $translationText = new TranslationText();

            $translationText
                ->setTranslation($translation)
                ->setLanguage($language)
            ;

        return $translationText;
    }
}
