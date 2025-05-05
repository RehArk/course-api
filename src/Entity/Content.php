<?php

namespace App\Entity;

use App\Repository\ContentRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;

/**
 * @codeCoverageIgnore
 */
#[ORM\Entity(repositoryClass: ContentRepository::class)]
#[ORM\Table(name: "contents")]
#[ORM\Index(columns: ["chapter_id"], name: "contents_index_chapter_id")]
#[ORM\Index(columns: ["parent_content_id"], name: "contents_index_parent_content_id")]
#[ORM\Index(columns: ["previous_content_id"], name: "contents_index_previous_content_id")]
#[ORM\Index(columns: ["next_content_id"], name: "contents_index_next_content_id")]
#[ORM\Index(columns: ["translation_id"], name: "contents_index_translation_id")]
#[ORM\Index(columns: ["type_id"], name: "contents_index_type_id")]
class Content
{
    #[ORM\Id]
    #[ORM\Column(type: 'guid')]
    #[ORM\GeneratedValue(strategy: "CUSTOM")]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private string $id;

    #[ORM\ManyToOne(targetEntity: Chapter::class)]
    #[ORM\JoinColumn(name: "chapter_id", referencedColumnName: "id")]
    private Chapter $chapter;

    #[ORM\ManyToOne(targetEntity: Content::class)]
    #[ORM\JoinColumn(name: "parent_content_id", referencedColumnName: "id", nullable: true)]
    private ?Content $parentContent = null;

    #[ORM\ManyToOne(targetEntity: Content::class)]
    #[ORM\JoinColumn(name: "previous_content_id", referencedColumnName: "id", nullable: true)]
    private ?Content $previousContent = null;

    #[ORM\ManyToOne(targetEntity: Content::class)]
    #[ORM\JoinColumn(name: "next_content_id", referencedColumnName: "id", nullable: true)]
    private ?Content $nextContent = null;

    #[ORM\ManyToOne(targetEntity: Translation::class, cascade: ['persist'])]
    #[ORM\JoinColumn(name: "translation_id", referencedColumnName: "id")]
    private Translation $translation;

    #[ORM\ManyToOne(targetEntity: ContentType::class)]
    #[ORM\JoinColumn(name: "type_id", referencedColumnName: "id")]
    private ContentType $type;

    #[ORM\Column(type: "datetime")]
    private DateTime $createdAt;

    #[ORM\Column(type: "datetime")]
    private DateTime $updatedAt;

    public function getId(): string
    {
        return $this->id;
    }

    public function getChapter(): Chapter
    {
        return $this->chapter;
    }

    public function setChapter(Chapter $chapter): self
    {
        $this->chapter = $chapter;
        return $this;
    }

    public function getParentContent(): ?Content
    {
        return $this->parentContent;
    }

    public function setParentContent(?Content $parentContent): self
    {
        $this->parentContent = $parentContent;
        return $this;
    }

    public function getPreviousContent(): ?Content
    {
        return $this->previousContent;
    }

    public function setPreviousContent(?Content $previousContent): self
    {
        $this->previousContent = $previousContent;
        return $this;
    }

    public function getNextContent(): ?Content
    {
        return $this->nextContent;
    }

    public function setNextContent(?Content $nextContent): self
    {
        $this->nextContent = $nextContent;
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

    public function getType(): ContentType
    {
        return $this->type;
    }

    public function setType(ContentType $type): self
    {
        $this->type = $type;
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
