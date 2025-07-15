<?php

namespace App\Entity;

use App\Repository\SessionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SessionRepository::class)]
class Session
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $min_participant = null;

    #[ORM\Column]
    private ?float $prix = null;

    /**
     * @var Collection<int, Affecte>
     */
    #[ORM\OneToMany(targetEntity: Affecte::class, mappedBy: 'session')]
    private Collection $affectes;

    #[ORM\ManyToOne(inversedBy: 'sessions')]
    private ?Formation $formation = null;

    /**
     * @var Collection<int, stagiaire>
     */
    #[ORM\ManyToMany(targetEntity: Stagiaire::class, inversedBy: 'sessions')]
    private Collection $stagiaires;

    #[ORM\OneToOne(inversedBy: 'session', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Checklist $checklist = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $date_debut = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $date_fin = null;

    #[ORM\ManyToOne(inversedBy: 'sessions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Salle $salle = null;

    public function __construct()
    {
        $this->affectes = new ArrayCollection();
        $this->stagiaires = new ArrayCollection();
        // Automatically create a checklist and link it
        $checklist = new Checklist();
        $checklist->setSession($this); // this will also set $this->checklist via setSession()
        $checklist->setSalle(false);
        $checklist->setMachines(false);
        $checklist->setSupports(false);
        $checklist->setFormulaire(false);
        $checklist->setFichePresence(false);
        $checklist->setTicketsRepas(false);
        $this->setChecklist($checklist);
    }

    public function __toString(): string
    {
        return $this->formation->getNom() . '_' . $this->getDateDebut()->format('Y-m-d').'_'.$this->getDateFin()->format('Y-m-d');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMinParticipant(): ?int
    {
        return $this->min_participant;
    }

    public function setMinParticipant(int $min_participant): static
    {
        $this->min_participant = $min_participant;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * @return Collection<int, Affecte>
     */
    public function getAffectes(): Collection
    {
        return $this->affectes;
    }

    public function addAffecte(Affecte $affecte): static
    {
        if (!$this->affectes->contains($affecte)) {
            $this->affectes->add($affecte);
            $affecte->setSession($this);
        }

        return $this;
    }

    public function removeAffecte(Affecte $affecte): static
    {
        if ($this->affectes->removeElement($affecte)) {
            // set the owning side to null (unless already changed)
            if ($affecte->getSession() === $this) {
                $affecte->setSession(null);
            }
        }

        return $this;
    }

    public function getFormation(): ?Formation
    {
        return $this->formation;
    }

    public function setFormation(?Formation $formation): static
    {
        $this->formation = $formation;

        return $this;
    }

    /**
     * @return Collection<int, stagiaire>
     */
    public function getStagiaires(): Collection
    {
        return $this->stagiaires;
    }

    public function addStagiaire(Stagiaire $stagiaire): static
    {
        if (!$this->stagiaires->contains($stagiaire)) {
            $this->stagiaires->add($stagiaire);
        }

        return $this;
    }

    public function removeStagiaire(Stagiaire $stagiaire): static
    {
        $this->stagiaires->removeElement($stagiaire);

        return $this;
    }

    public function getChecklist(): ?Checklist
    {
        return $this->checklist;
    }

    public function setChecklist(Checklist $checklist): static
    {
        $this->checklist = $checklist;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeImmutable
    {
        return $this->date_debut;
    }

    public function setDateDebut(\DateTimeImmutable $date_debut): static
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeImmutable
    {
        return $this->date_fin;
    }

    public function setDateFin(\DateTimeImmutable $date_fin): static
    {
        $this->date_fin = $date_fin;

        return $this;
    }

    public function getSalle(): ?Salle
    {
        return $this->salle;
    }

    public function setSalle(?Salle $salle): static
    {
        $this->salle = $salle;

        return $this;
    }
}
