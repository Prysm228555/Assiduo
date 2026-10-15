<?php

namespace App\Entity;

use App\Repository\JournalAuditRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JournalAuditRepository::class)]
class JournalAudit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $dateHeure = null;

    #[ORM\Column(length: 255)]
    private ?string $action = null;

    #[ORM\Column]
    private ?bool $autorisee = null;

    #[ORM\Column(length: 255)]
    private ?string $typeRessource = null;

    #[ORM\Column(nullable: true)]
    private ?int $idRessource = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $utilisateur = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateHeure(): ?\DateTimeImmutable
    {
        return $this->dateHeure;
    }

    public function setDateHeure(\DateTimeImmutable $dateHeure): static
    {
        $this->dateHeure = $dateHeure;

        return $this;
    }

    public function getAction(): ?string
    {
        return $this->action;
    }

    public function setAction(string $action): static
    {
        $this->action = $action;

        return $this;
    }

    public function isAutorisee(): ?bool
    {
        return $this->autorisee;
    }

    public function setAutorisee(bool $autorisee): static
    {
        $this->autorisee = $autorisee;

        return $this;
    }

    public function getTypeRessource(): ?string
    {
        return $this->typeRessource;
    }

    public function setTypeRessource(string $typeRessource): static
    {
        $this->typeRessource = $typeRessource;

        return $this;
    }

    public function getIdRessource(): ?int
    {
        return $this->idRessource;
    }

    public function setIdRessource(?int $idRessource): static
    {
        $this->idRessource = $idRessource;

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
}
