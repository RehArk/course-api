<?php

namespace App\Api\V1\State\Course;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Api\V1\Mapper\Course\CourseMapper;
use App\Entity\Course;
use App\Entity\Translation;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

class CourseProcessor implements ProcessorInterface
{

    private EntityManagerInterface $em;

    public function __construct(
        EntityManagerInterface $em
    ) {
        $this->em = $em;
    }

    public function process(
        mixed $data,
        Operation $operation,
        array $uriVariables = [],
        array $context = []
    ) {

        $course = new Course();
        $course
            ->setTranslation(new Translation())
            ->setCreatedAt(new DateTime())
            ->setUpdatedAt(new DateTime())
        ;

        $this->em->persist($course);
        $this->em->flush();

        return CourseMapper::fromEntity($course);
    }
}
