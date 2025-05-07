<?php

namespace App\Tests\Entity;

use PHPUnit\Framework\TestCase;
use App\Entity\Translation;
use App\Entity\TranslationText;
use App\Entity\Language;
use Doctrine\Common\Collections\ArrayCollection;

class TranslationTest extends TestCase
{
    public function testGetTranslationTextAndTextByLocale()
    {
        $frLanguage = $this->createMock(Language::class);
        $frLanguage->method('getCode')->willReturn('fr');

        $enLanguage = $this->createMock(Language::class);
        $enLanguage->method('getCode')->willReturn('en');

        $frText = $this->createMock(TranslationText::class);
        $frText->method('getLanguage')->willReturn($frLanguage);
        $frText->method('getText')->willReturn('Bonjour');

        $enText = $this->createMock(TranslationText::class);
        $enText->method('getLanguage')->willReturn($enLanguage);
        $enText->method('getText')->willReturn('Hello');

        $translation = new Translation();
        $reflection = new \ReflectionClass($translation);
        $property = $reflection->getProperty('translationTexts');
        $property->setAccessible(true);
        $property->setValue($translation, new ArrayCollection([$frText, $enText]));

        $this->assertSame($enText, $translation->getTranslationText('en'));
        $this->assertEquals('Hello', $translation->getText('en'));

        $this->assertNull($translation->getTranslationText('de'));
        $this->assertNull($translation->getText('de'));

        \Locale::setDefault('fr');
        $this->assertSame($frText, $translation->getTranslationText());
        $this->assertEquals('Bonjour', $translation->getText());
    }
}
