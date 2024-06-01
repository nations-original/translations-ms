<?php declare(strict_types=1);

namespace App\Entity;

use App\Repository\LocaleRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LocaleRepository::class)]
#[ORM\Table(name: 'locales')]
#[ORM\UniqueConstraint(name: 'name_application_uk', columns: ['name', 'application_id'])]
#[ORM\HasLifecycleCallbacks]
class Locale
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column(options: ['default' => true])]
    private bool $isActive = true;

    #[ORM\Column(options: ['default' => 'CURRENT_TIMESTAMP'])]
    private DateTimeImmutable $createdAt;


    #[ORM\ManyToOne(inversedBy: 'locales')]
    #[ORM\JoinColumn(referencedColumnName: 'uuid', nullable: false)]
    private ?Application $application = null;

    /**
     * @var Collection<int, Translation>
     */
    #[ORM\OneToMany(targetEntity: Translation::class, mappedBy: 'locale', cascade: [
        'persist',
        'remove',
    ], orphanRemoval: true)]
    private Collection $translations;


    public function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
        $this->translations = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
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


    public function getApplication(): Application
    {
        return $this->application;
    }

    public function setApplication(?Application $application): self
    {
        $this->application = $application;

        return $this;
    }

    /**
     * @return Collection<int, Translation>
     */
    public function getTranslations(): Collection
    {
        return $this->translations;
    }

    public function addTranslation(Translation $translation): static
    {
        if (!$this->translations->contains($translation)) {
            $this->translations->add($translation);
            $translation->setLocale($this);
        }

        return $this;
    }

    public function removeTranslation(Translation $translation): static
    {
        if ($this->translations->removeElement($translation)) {
            // set the owning side to null (unless already changed)
            if ($translation->getLocale() === $this) {
                $translation->setLocale(null);
            }
        }

        return $this;
    }


    #[ORM\PrePersist]
    public function prePersist(): void
    {
        // check if another locale exists for the application
        $locales = $this->getApplication()->getLocales();
        if ($locales->count() === 1) {
            return;
        }

        // copy all keys from the first locale to the new locale
        $anotherLocale = $locales->first();
        while ($anotherLocale === $this) {
            $anotherLocale = $locales->next();
        }

        if ($anotherLocale === false) {
            return; // happens when the first locale added
        }

        foreach ($anotherLocale->getTranslations() as $translation) {
            $this->addTranslation(
                (new Translation())
                    ->setLocale($this)
                    ->setString($translation->getString())
            );
        }
    }
}
