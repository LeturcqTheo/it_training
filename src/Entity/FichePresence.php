<?php

namespace App\Entity;

use App\Repository\FichePresenceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FichePresenceRepository::class)]
class FichePresence
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $jour = null;

    #[ORM\Column]
    private ?bool $est_present = null;

    #[ORM\Column(nullable: true)]
    private ?int $retard = null;

    #[ORM\ManyToOne(inversedBy: 'fiches_presence')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Stagiaire $stagiaire = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getJour(): ?\DateTime
    {
        return $this->jour;
    }

    public function setJour(\DateTime $jour): static
    {
        $this->jour = $jour;

        return $this;
    }

    public function isEstPresent(): ?bool
    {
        return $this->est_present;
    }

    public function setEstPresent(bool $est_present): static
    {
        $this->est_present = $est_present;

        return $this;
    }

    public function getRetard(): ?int
    {
        return $this->retard;
    }

    public function setRetard(?int $retard): static
    {
        $this->retard = $retard;

        return $this;
    }

    public function getStagiaire(): ?Stagiaire
    {
        return $this->stagiaire;
    }

    public function setStagiaire(?Stagiaire $stagiaire): static
    {
        $this->stagiaire = $stagiaire;

        return $this;
    }
}
