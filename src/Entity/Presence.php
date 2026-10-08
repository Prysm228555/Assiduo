<?php

namespace App\Entity;

use App\Repository\PresenceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PresenceRepository::class)]
class Presence
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $status = null;

    #[ORM\Column(nullable: true)]
    private ?int $dureeRetard = null;

    #[ORM\Column]
    private ?bool $justifie = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $motif = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $dateQualification = null;

    #[ORM\ManyToOne(inversedBy: 'presences')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Appel $appel = null;

    #[ORM\ManyToOne(inversedBy: 'presences')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Eleve $eleve = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getDureeRetard(): ?int
    {
        return $this->dureeRetard;
    }

    public function setDureeRetard(?int $dureeRetard): static
    {
        $this->dureeRetard = $dureeRetard;

        return $this;
    }

    public function isJustifie(): ?bool
    {
        return $this->justifie;
    }

    public function setJustifie(bool $justifie): static
    {
        $this->justifie = $justifie;

        return $this;
    }

    public function getMotif(): ?string
    {
        return $this->motif;
    }

    public function setMotif(?string $motif): static
    {
        $this->motif = $motif;

        return $this;
    }

    public function getDateQualification(): ?\DateTimeImmutable
    {
        return $this->dateQualification;
    }

    public function setDateQualification(?\DateTimeImmutable $dateQualification): static
    {
        $this->dateQualification = $dateQualification;

        return $this;
    }

    public function getAppel(): ?Appel
    {
        return $this->appel;
    }

    public function setAppel(?Appel $appel): static
    {
        $this->appel = $appel;

        return $this;
    }

    public function getEleve(): ?Eleve
    {
        return $this->eleve;
    }

    public function setEleve(?Eleve $eleve): static
    {
        $this->eleve = $eleve;

        return $this;
    }
}
