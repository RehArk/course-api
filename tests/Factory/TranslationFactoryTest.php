<?php

namespace App\Tests\Factory;

use App\Entity\Language;
use App\Entity\Translation;
use App\Entity\TranslationText;
use App\Factory\TranslationFactory;
use App\Repository\LanguageRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class TranslationFactoryTest extends TestCase
{
    public function testCreateWithDefaultEnglishText_usesExistingLanguage()
    {
        $language = new Language();
        $language->setCode('en')->setName('English');

        /** @var \PHPUnit\Framework\MockObject\MockObject&\App\Repository\LanguageRepository $repo */
        $repo = $this->createMock(LanguageRepository::class);
        $repo->method('findOneBy')->with(['code' => 'en'])->willReturn($language);

        /** @var \PHPUnit\Framework\MockObject\MockObject&\Doctrine\ORM\EntityManagerInterface $em */
        $em = $this->createMock(EntityManagerInterface::class);
        $em->expects($this->never())->method('persist');

        $factory = new TranslationFactory($repo, $em);

        $translation = $factory->createWithDefaultEnglishText('Hello');

        $this->assertInstanceOf(Translation::class, $translation);
        $text = $translation->getTranslationText('en');
        $this->assertInstanceOf(TranslationText::class, $text);
        $this->assertEquals('Hello', $text->getText());
    }

    public function testCreateWithDefaultEnglishText_createsLanguageIfNotExists()
    {

        /** @var \PHPUnit\Framework\MockObject\MockObject&\App\Repository\LanguageRepository $repo */
        $repo = $this->createMock(LanguageRepository::class);
        $repo->method('findOneBy')->willReturn(null);

        /** @var \PHPUnit\Framework\MockObject\MockObject&\Doctrine\ORM\EntityManagerInterface $em */
        $em = $this->createMock(EntityManagerInterface::class);
        $em->expects($this->once())->method('persist')->with($this->isInstanceOf(Language::class));

        $factory = new TranslationFactory($repo, $em);

        $translation = $factory->createWithDefaultEnglishText('Hello');

        $text = $translation->getTranslationText('en');
        $this->assertEquals('Hello', $text->getText());
        $this->assertEquals('en', $text->getLanguage()->getCode());
    }

    public function testFindOrCreate_returnsExistingTranslationText()
    {
        $language = new Language();
        $language->setCode('fr');

        $translationText = new TranslationText();
        $translationText->setLanguage($language)->setText('Bonjour');

        $translation = new Translation();
        $translation->addTranslationText($translationText);

        /** @var \PHPUnit\Framework\MockObject\MockObject&\App\Repository\LanguageRepository $repo */
        $repo = $this->createMock(LanguageRepository::class);

        /** @var \PHPUnit\Framework\MockObject\MockObject&\Doctrine\ORM\EntityManagerInterface $em */
        $em = $this->createMock(EntityManagerInterface::class);

        $factory = new TranslationFactory($repo, $em);

        $result = $factory->findOrCreate($translation, $language);

        $this->assertSame($translationText, $result);
    }

    public function testFindOrCreate_createsNewTranslationTextIfNotExists()
    {
        $language = new Language();
        $language->setCode('de');

        $translation = new Translation();
        
        /** @var \PHPUnit\Framework\MockObject\MockObject&\App\Repository\LanguageRepository $repo */
        $repo = $this->createMock(LanguageRepository::class);

        /** @var \PHPUnit\Framework\MockObject\MockObject&\Doctrine\ORM\EntityManagerInterface $em */
        $em = $this->createMock(EntityManagerInterface::class);

        $factory = new TranslationFactory($repo, $em);

        $result = $factory->findOrCreate($translation, $language);

        $this->assertInstanceOf(TranslationText::class, $result);
        $this->assertSame($language, $result->getLanguage());
        $this->assertSame($translation, $result->getTranslation());
    }
}
