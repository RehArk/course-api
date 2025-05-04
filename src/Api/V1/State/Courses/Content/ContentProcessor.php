<?php

namespace App\Api\V1\State\Courses\Content;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Api\V1\Mapper\Courses\Content\ContentMapper;
use App\Api\V1\Services\Courses\Content\ContentPreparer;
use App\Entity\Content;
use App\Factory\TranslationFactory;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

class ContentProcessor implements ProcessorInterface
{

    private EntityManagerInterface $em;
    private ContentPreparer $preparer;
    private TranslationFactory $translationFactory;


    public function __construct(
        EntityManagerInterface $em,
        ContentPreparer $preparer,
        TranslationFactory $translationFactory

    ) {
        $this->em = $em;
        $this->preparer = $preparer;
        $this->translationFactory = $translationFactory;
    }

    public function process(
        mixed $data,
        Operation $operation,
        array $uriVariables = [],
        array $context = []
    ) {

        /** @var \App\Api\V1\Dto\Courses\Content\PreparedContentInput */
        $preparedInput = $this->preparer->prepare($data);

        $defaultTranslation = $this->translationFactory
            ->createWithDefaultEnglishText($preparedInput->defaultContent);

        $content = new Content();
        $content
            ->setChapter($preparedInput->chapter)
            ->setType($preparedInput->contentType)
            ->setParentContent($preparedInput->parentContent)
            ->setPreviousContent($preparedInput->previousContent)
            ->setTranslation($defaultTranslation)
            ->setCreatedAt(new DateTime())
            ->setUpdatedAt(new DateTime())
        ;

        if ($preparedInput->previousContent) {
            $preparedInput->previousContent->setNextContent($content);
            $this->em->persist($preparedInput->previousContent);
        }

        $this->em->persist($content);
        $this->em->flush();

        return ContentMapper::fromEntity($content);
    }
}
