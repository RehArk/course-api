<?php

namespace App\Api\V1\State\Courses\Course;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Api\V1\Mapper\Courses\Course\CourseMapper;
use App\Api\V1\Services\Courses\Course\CoursePreparer;
use App\Entity\Course;
use App\Factory\TranslationFactory;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

class CourseProcessor implements ProcessorInterface
{

    private EntityManagerInterface $em;
    private CoursePreparer $preparer;
    private TranslationFactory $translationFactory;
    private CourseMapper $mapper;


    public function __construct(
        EntityManagerInterface $em,
        CoursePreparer $preparer,
        TranslationFactory $translationFactory,
        CourseMapper $mapper
    ) {
        $this->em = $em;
        $this->preparer = $preparer;
        $this->translationFactory = $translationFactory;
        $this->mapper = $mapper;
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

        /** @var \App\Api\V1\Dto\Courses\Course\PreparedCourseInput */
        $preparedInput = $this->preparer->prepare($data);

        $defaultTranslation = $this->translationFactory
            ->createWithDefaultEnglishText($preparedInput->defaultTitle);

        $course = new Course();
        $course
            ->setTranslation($defaultTranslation)
            ->setCreatedAt(new DateTime())
            ->setUpdatedAt(new DateTime())
        ;

        $this->em->persist($course);
        $this->em->flush();

        return $this->mapper->fromEntity($course);
    }
}
