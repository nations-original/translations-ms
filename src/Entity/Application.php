<?php declare(strict_types=1);

namespace App\Entity;

use App\Repository\ApplicationRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: ApplicationRepository::class)]
#[ORM\Table(name: 'applications')]
class Application
{

    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private Uuid $uuid;

    #[ORM\Column(unique: true)]
    private string $name;

    #[ORM\Column(type: Types::TEXT)]
    private string $password;

    #[ORM\Column(options: ['default' => true])]
    private bool $isActive = true;

    #[ORM\Column(options: ['default' => 'CURRENT_TIMESTAMP'])]
    private DateTimeImmutable $createdAt;

    /**
     * @var Collection<int, Locale>
     */
    #[ORM\OneToMany(targetEntity: Locale::class, mappedBy: 'application', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $locales;


    public function __construct()
    {
        $this->uuid = Uuid::v4();
        $this->createdAt = new DateTimeImmutable();
        $this->locales = new ArrayCollection();
    }


    public function getUuid(): Uuid
    {
        return $this->uuid;
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

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = password_hash($password, PASSWORD_ARGON2I);

        return $this;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function setActive(bool $isActive): self
    {
        $this->isActive = $isActive;

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


    /**
     * @return Collection<int, Locale>
     */
    public function getLocales(): Collection
    {
        return $this->locales;
    }

    public function addLocale(Locale $locale): static
    {
        if (!$this->locales->contains($locale)) {
            $this->locales->add($locale);
            $locale->setApplication($this);
        }

        return $this;
    }

}
