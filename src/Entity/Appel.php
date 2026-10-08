<?php

namespace App\Entity;

use App\Repository\AppelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AppelRepository::class)]
class Appel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $dateAppel = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $horodatageValidation = null;

    #[ORM\Column]
    private ?bool $verrouille = null;

    #[ORM\ManyToOne(inversedBy: 'appels')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Creneau $creneau = null;

    /**
     * @var Collection<int, Presence>
     */
    #[ORM\OneToMany(targetEntity: Presence::class, mappedBy: 'appel')]
    private Collection $presences;

    public function __construct()
    {
        $this->presences = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateAppel(): ?\DateTimeImmutable
    {
        return $this->dateAppel;
    }

    public function setDateAppel(\DateTimeImmutable $dateAppel): static
    {
        $this->dateAppel = $dateAppel;

        return $this;
    }

    public function getHorodatageValidation(): ?\DateTimeImmutable
    {
        return $this->horodatageValidation;
    }

    public function setHorodatageValidation(?\DateTimeImmutable $horodatageValidation): static
    {
        $this->horodatageValidation = $horodatageValidation;

        return $this;
    }

    public function isVerrouille(): ?bool
    {
        return $this->verrouille;
    }

    public function setVerrouille(bool $verrouille): static
    {
        $this->verrouille = $verrouille;

        return $this;
    }

    public function getCreneau(): ?Creneau
    {
        return $this->creneau;
    }

    public function setCreneau(?Creneau $creneau): static
    {
        $this->creneau = $creneau;

        return $this;
    }

    /**
     * @return Collection<int, Presence>
     */
    public function getPresences(): Collection
    {
        return $this->presences;
    }

    public function addPresence(Presence $presence): static
    {
        if (!$this->presences->contains($presence)) {
            $this->presences->add($presence);
            $presence->setAppel($this);
        }

        return $this;
    }

    public function removePresence(Presence $presence): static
    {
        if ($this->presences->removeElement($presence)) {
            // set the owning side to null (unless already changed)
            if ($presence->getAppel() === $this) {
                $presence->setAppel(null);
            }
        }

        return $this;
    }
}
