<?php

namespace App\Api\V1\State\Translation;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Api\V1\Dto\Translation\TranslationOutput;
use App\Api\V1\Services\Translation\TranslationPreparer;
use App\Entity\Course;
use App\Factory\TranslationFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TranslationProcessor implements ProcessorInterface
{

    private EntityManagerInterface $em;
    private TranslationPreparer $preparer;
    private TranslationFactory $translationFactory;

    public function __construct(
        EntityManagerInterface $em,
        TranslationPreparer $preparer,
        TranslationFactory $translationFactory
    ) {
        $this->em = $em;
        $this->preparer = $preparer;
        $this->translationFactory = $translationFactory;
    }

    /**
     * Handles the state.
     *
     * @param T1                                                                                                                        $data
     * @param array<string, mixed>                                                                                                      $uriVariables
     * @param array<string, mixed>&array{request?: Request, previous_data?: mixed, resource_class?: string|null, original_data?: mixed} $context
     *
     * @return T2
     */
    public function process(
        mixed $data,
        Operation $operation,
        array $uriVariables = [],
        array $context = []
    ) {

        /** @var \App\Api\V1\Dto\Translation\PreparedTranslationInput */
        $preparedInput = $this->preparer->prepare($data);

        $entityClass = $context['resource_class']::getEntityClass();
        $repository = $this->em->getRepository($entityClass);

        /** @var \App\Utils\Translation\TranslatableEntityInterface */
        $entity = $repository->findOneBy(['id' => $uriVariables['id']]);

        if(!$entity) {
            throw new NotFoundHttpException('Resource ' . $uriVariables['id'] . ' not found');
        }

        $translationText = $this->translationFactory->findOrCreate(
            $entity->getTranslation(),
            $preparedInput->language
        );

        $translationText->setText($preparedInput->text);

        $this->em->persist($translationText);
        $this->em->flush();

        return new TranslationOutput(
            $translationText->getLanguage()->getCode(),
            $translationText->getText()
        );
    }
}
