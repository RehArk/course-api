<?php

namespace App\Entity;

use App\Repository\CourseRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;

#[ORM\Entity(repositoryClass: CourseRepository::class)]
#[ORM\Table(name: "courses")]
#[ORM\Index(columns: ["translation_id"], name: "courses_index_translation_id")]
class Course
{
    #[ORM\Id]
    #[ORM\Column(type: 'guid')]
    #[ORM\GeneratedValue(strategy: "CUSTOM")]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private string $id;

    #[ORM\ManyToOne(targetEntity: Translation::class)]
    #[ORM\JoinColumn(name: "translation_id", referencedColumnName: "id")]
    private Translation $translation;

    #[ORM\Column(type: "datetime")]
    private DateTime $createdAt;

    #[ORM\Column(type: "datetime")]
    private DateTime $updatedAt;

    public function getId(): string
    {
        return $this->id;
    }

    public function getTranslation(): Translation
    {
        return $this->translation;
    }

    public function setTranslation(Translation $translation): self
    {
        $this->translation = $translation;
        return $this;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
}
