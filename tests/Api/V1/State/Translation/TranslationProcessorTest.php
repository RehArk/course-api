<?php

namespace App\Tests\Api\V1\State\Translation;

use App\Api\V1\Dto\Translation\PreparedTranslationInput;
use App\Api\V1\Dto\Translation\TranslationOutput;
use App\Api\V1\Services\Translation\TranslationPreparer;
use App\Api\V1\State\Translation\TranslationProcessor;
use App\Entity\Language;
use App\Entity\Translation;
use App\Entity\TranslationText;
use App\Factory\TranslationFactory;
use App\Utils\Translation\TranslatableEntityInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use ApiPlatform\Metadata\Operation;
use Doctrine\ORM\EntityRepository;

class TranslationProcessorTest extends TestCase
{
    public function testProcessReturnsOutputCorrectly()
    {
        $id = 1;
        $language = new Language();
        $text = 'Test';

        $language->setCode('fr');

        $preparedInput = new PreparedTranslationInput(
            $language,
            $text
        );

        $translationText = new TranslationText();
        $translationText->setLanguage($language);

        $translation = new Translation();
        $translatableEntity = $this->createMock(TranslatableEntityInterface::class);
        $translatableEntity->method('getTranslation')->willReturn($translation);

        /** @var \PHPUnit\Framework\MockObject\MockObject&\App\Repository\LanguageRepository $repo */
        $repository = $this->createMock(EntityRepository::class);
        $repository->method('findOneBy')->with(['id' => $id])->willReturn($translatableEntity);

        /** @var \PHPUnit\Framework\MockObject\MockObject&\Doctrine\ORM\EntityManagerInterface $em */
        $em = $this->createMock(EntityManagerInterface::class);
        $em->method('getRepository')->willReturn($repository);
        $em->expects($this->once())->method('persist')->with($translationText);
        $em->expects($this->once())->method('flush');

        /** @var \PHPUnit\Framework\MockObject\MockObject&\App\Api\V1\Services\Translation\TranslationPreparer $translationPreparer */
        $translationPreparer = $this->createMock(TranslationPreparer::class);
        $translationPreparer->method('prepare')->willReturn($preparedInput);

        /** @var \PHPUnit\Framework\MockObject\MockObject&\App\Factory\TranslationFactory $translationFactory */
        $translationFactory = $this->createMock(TranslationFactory::class);
        $translationFactory->method('findOrCreate')->willReturn($translationText);

        $processor = new TranslationProcessor(
            $em,
            $translationPreparer,
            $translationFactory
        );

        $resourceClass = new class {
            public static function getEntityClass(): string
            {
                return TranslatableEntityInterface::class;
            }
        };

        $context = ['resource_class' => $resourceClass];

        /** @var \PHPUnit\Framework\MockObject\MockObject&\ApiPlatform\Metadata\Operation $operation */
        $operation = $this->createMock(Operation::class);

        $res = $processor->process(
            new \stdClass(),
            $operation,
            ['id' => $id],
            $context
        );

        $this->assertInstanceOf(TranslationOutput::class, $res);
        $this->assertEquals($language->getCode(), $res->local);
        $this->assertEquals($text, $res->text);
    }

    public function testProcessThrows404WhenEntityNotFound()
    {

        $id = 1;
        $language = new Language();
        $text = 'Test';

        $preparedInput = new PreparedTranslationInput(
            $language,
            $text
        );

        /** @var \PHPUnit\Framework\MockObject\MockObject&\App\Repository\LanguageRepository $repo */
        $repository = $this->createMock(EntityRepository::class);
        $repository->method('findOneBy')->willReturn(null);

        /** @var \PHPUnit\Framework\MockObject\MockObject&\Doctrine\ORM\EntityManagerInterface $em */
        $em = $this->createMock(EntityManagerInterface::class);
        $em->method('getRepository')->willReturn($repository);

        /** @var \PHPUnit\Framework\MockObject\MockObject&\App\Api\V1\Services\Translation\TranslationPreparer $translationPreparer */
        $translationPreparer = $this->createMock(TranslationPreparer::class);
        $translationPreparer->method('prepare')->willReturn($preparedInput);

        /** @var \PHPUnit\Framework\MockObject\MockObject&\App\Factory\TranslationFactory $translationFactory */
        $translationFactory = $this->createMock(TranslationFactory::class);

        $processor = new TranslationProcessor(
            $em,
            $translationPreparer,
            $translationFactory
        );

        $resourceClass = new class {
            public static function getEntityClass(): string
            {
                return TranslatableEntityInterface::class;
            }
        };

        $context = ['resource_class' => $resourceClass];

        /** @var \PHPUnit\Framework\MockObject\MockObject&\ApiPlatform\Metadata\Operation $operation */
        $operation = $this->createMock(Operation::class);

        $this->expectException(NotFoundHttpException::class);

        $processor->process(
            new \stdClass(),
            $operation,
            ['id' => $id],
            $context
        );
    }
}
