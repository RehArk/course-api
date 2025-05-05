<?php

namespace App\Entity;

use App\Repository\LanguageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @codeCoverageIgnore
 */
#[ORM\Entity(repositoryClass: LanguageRepository::class)]
#[ORM\Table(name: "languages")]
#[ORM\Index(columns: ["code"], name: "languages_index_code")]
class Language
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Column(type: "string", length: 10, unique: true)]
    private string $code;

    #[ORM\Column(type: "string", length: 100)]
    private string $name;

    public function getId(): int
    {
        return $this->id;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }
}
