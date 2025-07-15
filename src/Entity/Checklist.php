<?php

namespace App\Entity;

use App\Repository\ChecklistRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChecklistRepository::class)]
class Checklist
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $salle = null;

    #[ORM\Column]
    private ?bool $machines = null;

    #[ORM\Column]
    private ?bool $supports = null;

    #[ORM\Column]
    private ?bool $formulaire = null;

    #[ORM\Column]
    private ?bool $fichePresence = null;

    #[ORM\Column]
    private ?bool $ticketsRepas = null;

    #[ORM\OneToOne(mappedBy: 'checklist', cascade: ['persist', 'remove'])]
    private ?Session $session = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isSalle(): ?bool
    {
        return $this->salle;
    }

    public function setSalle(bool $salle): static
    {
        $this->salle = $salle;

        return $this;
    }

    public function isMachines(): ?bool
    {
        return $this->machines;
    }

    public function setMachines(bool $machines): static
    {
        $this->machines = $machines;

        return $this;
    }

    public function isSupports(): ?bool
    {
        return $this->supports;
    }

    public function setSupports(bool $supports): static
    {
        $this->supports = $supports;

        return $this;
    }

    public function isFormulaire(): ?bool
    {
        return $this->formulaire;
    }

    public function setFormulaire(bool $formulaire): static
    {
        $this->formulaire = $formulaire;

        return $this;
    }

    public function isFichePresence(): ?bool
    {
        return $this->fichePresence;
    }

    public function setFichePresence(bool $fichePresence): static
    {
        $this->fichePresence = $fichePresence;

        return $this;
    }

    public function isTicketsRepas(): ?bool
    {
        return $this->ticketsRepas;
    }

    public function setTicketsRepas(bool $ticketsRepas): static
    {
        $this->ticketsRepas = $ticketsRepas;

        return $this;
    }

    public function getSession(): ?Session
    {
        return $this->session;
    }

    public function setSession(Session $session): static
    {
        // set the owning side of the relation if necessary
        if ($session->getChecklist() !== $this) {
            $session->setChecklist($this);
        }

        $this->session = $session;

        return $this;
    }
}
