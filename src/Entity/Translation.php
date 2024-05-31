<?php declare(strict_types=1);

namespace App\Entity;

use App\Repository\TranslationRepository;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TranslationRepository::class)]
class Translation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $string = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $translation = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $translationMale = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $translationFemale = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $translationOne = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $translationFew = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $translationMany = null;

    #[ORM\Column(options: ['default' => 'CURRENT_TIMESTAMP'])]
    private DateTimeImmutable $createdAt;

    #[ORM\Column(nullable: true, columnDefinition: 'TIMESTAMP on update CURRENT_TIMESTAMP')]
    private ?DateTimeImmutable $updatedAt = null;


    #[ORM\ManyToOne(inversedBy: 'translations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Locale $locale = null;


    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getString(): ?string
    {
        return $this->string;
    }

    public function setString(string $string): self
    {
        $this->string = $string;

        return $this;
    }

    public function getTranslation(): ?string
    {
        return $this->translation;
    }

    public function setTranslation(?string $translation): static
    {
        $this->translation = $translation;

        return $this;
    }

    public function getTranslationMale(): ?string
    {
        return $this->translationMale;
    }

    public function setTranslationMale(?string $translationMale): static
    {
        $this->translationMale = $translationMale;

        return $this;
    }

    public function getTranslationFemale(): ?string
    {
        return $this->translationFemale;
    }

    public function setTranslationFemale(?string $translationFemale): static
    {
        $this->translationFemale = $translationFemale;

        return $this;
    }

    public function getTranslationOne(): ?string
    {
        return $this->translationOne;
    }

    public function setTranslationOne(?string $translationOne): static
    {
        $this->translationOne = $translationOne;

        return $this;
    }

    public function getTranslationFew(): ?string
    {
        return $this->translationFew;
    }

    public function setTranslationFew(?string $translationFew): static
    {
        $this->translationFew = $translationFew;

        return $this;
    }

    public function getTranslationMany(): ?string
    {
        return $this->translationMany;
    }

    public function setTranslationMany(?string $translationMany): static
    {
        $this->translationMany = $translationMany;

        return $this;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }


    public function getLocale(): ?Locale
    {
        return $this->locale;
    }

    public function setLocale(?Locale $locale): self
    {
        $this->locale = $locale;

        return $this;
    }

}
