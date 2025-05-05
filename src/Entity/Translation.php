<?php

namespace App\Entity;

use App\Repository\TranslationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;

#[ORM\Entity(repositoryClass: TranslationRepository::class)]
#[ORM\Table(name: "translations")]
class Translation
{

    /**
     * @codeCoverageStart
     */
    #[ORM\Id]
    #[ORM\Column(type: 'guid')]
    #[ORM\GeneratedValue(strategy: "CUSTOM")]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private string $id;

    #[ORM\OneToMany(mappedBy: "translation", targetEntity: TranslationText::class, cascade: ['persist'], orphanRemoval: true)]
    private Collection $translationTexts;

    public function __construct()
    {
        $this->translationTexts = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTranslationTexts(): Collection
    {
        return $this->translationTexts;
    }

    public function addTranslationText(TranslationText $translationText): self
    {
        if (!$this->translationTexts->contains($translationText)) {
            $this->translationTexts->add($translationText);
            $translationText->setTranslation($this);
        }

        return $this;
    }

    public function removeTranslationText(TranslationText $translationText): self
    {
        if ($this->translationTexts->removeElement($translationText)) {
            if ($translationText->getTranslation() === $this) {
                $translationText->setTranslation(null);
            }
        }

        return $this;
    }

    /**
     * @codeCoverageEnd
     */

    public function getTranslationText(
        ?string $locale = null
    ): ?TranslationText {

        $locale = $locale ?? \Locale::getDefault();

        $translationText = $this->getTranslationTexts()->filter(
            fn($translationText) => $translationText->getLanguage()->getCode() === $locale
        )->first() ?: null;

        return $translationText;
    }

    public function getText(
        ?string $locale = null
    ): ?string {
        return $this->getTranslationText($locale)?->getText();
    }
}
