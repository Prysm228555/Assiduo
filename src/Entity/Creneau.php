<?php

namespace App\Entity;

use App\Repository\CreneauRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CreneauRepository::class)]
class Creneau
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $JourSemaine = null;

    #[ORM\Column(type: Types::TIME_IMMUTABLE)]
    private ?\DateTimeImmutable $heureDebut = null;

    #[ORM\Column(type: Types::TIME_IMMUTABLE)]
    private ?\DateTimeImmutable $heurefin = null;

    #[ORM\ManyToOne(inversedBy: 'creneaus')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $utilisateur = null;

    /**
     * @var Collection<int, Classe>
     */
    #[ORM\ManyToMany(targetEntity: Classe::class, inversedBy: 'creneaus')]
    private Collection $classes;

    /**
     * @var Collection<int, Appel>
     */
    #[ORM\OneToMany(targetEntity: Appel::class, mappedBy: 'creneau')]
    private Collection $appels;

    public function __construct()
    {
        $this->classes = new ArrayCollection();
        $this->appels = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getJourSemaine(): ?string
    {
        return $this->JourSemaine;
    }

    public function setJourSemaine(string $JourSemaine): static
    {
        $this->JourSemaine = $JourSemaine;

        return $this;
    }

    public function getHeureDebut(): ?\DateTimeImmutable
    {
        return $this->heureDebut;
    }

    public function setHeureDebut(\DateTimeImmutable $heureDebut): static
    {
        $this->heureDebut = $heureDebut;

        return $this;
    }

    public function getHeurefin(): ?\DateTimeImmutable
    {
        return $this->heurefin;
    }

    public function setHeurefin(\DateTimeImmutable $heurefin): static
    {
        $this->heurefin = $heurefin;

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): static
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    /**
     * @return Collection<int, Classe>
     */
    public function getClasses(): Collection
    {
        return $this->classes;
    }

    public function addClass(Classe $class): static
    {
        if (!$this->classes->contains($class)) {
            $this->classes->add($class);
        }

        return $this;
    }

    public function removeClass(Classe $class): static
    {
        $this->classes->removeElement($class);

        return $this;
    }

    /**
     * @return Collection<int, Appel>
     */
    public function getAppels(): Collection
    {
        return $this->appels;
    }

    public function addAppel(Appel $appel): static
    {
        if (!$this->appels->contains($appel)) {
            $this->appels->add($appel);
            $appel->setCreneau($this);
        }

        return $this;
    }

    public function removeAppel(Appel $appel): static
    {
        if ($this->appels->removeElement($appel)) {
            // set the owning side to null (unless already changed)
            if ($appel->getCreneau() === $this) {
                $appel->setCreneau(null);
            }
        }

        return $this;
    }
}
