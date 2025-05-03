<?php

namespace App\Entity;

use App\Repository\ChapterRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;

#[ORM\Entity(repositoryClass: ChapterRepository::class)]
#[ORM\Table(name: 'chapters')]
#[ORM\Index(columns: ['course_id'], name: 'chapters_index_course_id')]
#[ORM\Index(columns: ['translation_id'], name: 'chapters_index_translation_id')]
#[ORM\Index(columns: ['previous_chapter_id'], name: 'chapters_index_previous_chapter_id')]
#[ORM\Index(columns: ['next_chapter_id'], name: 'chapters_index_next_chapter_id')]
class Chapter
{
    #[ORM\Id]
    #[ORM\Column(type: 'guid')]
    #[ORM\GeneratedValue(strategy: "CUSTOM")]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private string $id;

    #[ORM\ManyToOne(targetEntity: Course::class)]
    #[ORM\JoinColumn(name: 'course_id', referencedColumnName: 'id')]
    private Course $course;

    #[ORM\ManyToOne(targetEntity: Translation::class)]
    #[ORM\JoinColumn(name: "translation_id", referencedColumnName: "id")]
    private Translation $translation;

    #[ORM\ManyToOne(targetEntity: self::class)]
    #[ORM\JoinColumn(name: 'previous_chapter_id', referencedColumnName: 'id', nullable: true)]
    private ?Chapter $previousChapter;

    #[ORM\ManyToOne(targetEntity: self::class)]
    #[ORM\JoinColumn(name: 'next_chapter_id', referencedColumnName: 'id', nullable: true)]
    private ?Chapter $nextChapter;

    #[ORM\Column(type: 'datetime')]
    private DateTime $createdAt;

    #[ORM\Column(type: 'datetime')]
    private DateTime $updatedAt;

    public function getId(): string
    {
        return $this->id;
    }

    public function getCourse(): Course
    {
        return $this->course;
    }

    public function setCourse(Course $course): self
    {
        $this->course = $course;
        return $this;
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

    public function getPreviousChapter(): ?Chapter
    {
        return $this->previousChapter;
    }

    public function setPreviousChapter(?Chapter $previousChapter): self
    {
        $this->previousChapter = $previousChapter;
        return $this;
    }

    public function getNextChapter(): ?Chapter
    {
        return $this->nextChapter;
    }

    public function setNextChapter(?Chapter $nextChapter): self
    {
        $this->nextChapter = $nextChapter;
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
