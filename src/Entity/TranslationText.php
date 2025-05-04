<?php

namespace App\Entity;

use App\Repository\TranslationTextRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;

#[ORM\Entity(repositoryClass: TranslationTextRepository::class)]
#[ORM\Table(name: "translation_texts")]
#[ORM\Index(columns: ["translation_id"], name: "translation_texts_index_translation_id")]
#[ORM\Index(columns: ["language_id"], name: "translation_texts_index_language_id")]
#[ORM\UniqueConstraint(name: "translation_texts_index_unique_translation_texts_id", columns: ["translation_id", "language_id"])]
class TranslationText
{
    #[ORM\Id]
    #[ORM\Column(type: 'guid')]
    #[ORM\GeneratedValue(strategy: "CUSTOM")]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private string $id;

    #[ORM\ManyToOne(targetEntity: Translation::class)]
    #[ORM\JoinColumn(name: "translation_id", referencedColumnName: "id")]
    private Translation $translation;

    #[ORM\ManyToOne(targetEntity: Language::class)]
    #[ORM\JoinColumn(name: "language_id", referencedColumnName: "id")]
    private Language $language;

    #[ORM\Column(type: "text")]
    private string $text;

    public function getId(): string
    {
        return $this->id;
    }

    public function getTranslation(): Translation
    {
        return $this->translation;
    }

    public function setTranslation(?Translation $translation): self
    {
        $this->translation = $translation;
        return $this;
    }

    public function getLanguage(): Language
    {
        return $this->language;
    }

    public function setLanguage(Language $language): self
    {
        $this->language = $language;
        return $this;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;
        return $this;
    }
}
