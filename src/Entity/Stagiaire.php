<?php

namespace App\Entity;

use App\Repository\StagiaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StagiaireRepository::class)]
class Stagiaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $diplome = null;

    #[ORM\Column]
    private ?bool $prerequis_valide = null;

    /**
     * @var Collection<int, Session>
     */
    #[ORM\ManyToMany(targetEntity: Session::class, mappedBy: 'stagiaires')]
    private Collection $sessions;

    /**
     * @var Collection<int, note>
     */
    #[ORM\OneToMany(targetEntity: Note::class, mappedBy: 'stagiaire', orphanRemoval: true)]
    private Collection $notes;

    /**
     * @var Collection<int, formsatisfaction>
     */
    #[ORM\OneToMany(targetEntity: FormSatisfaction::class, mappedBy: 'stagiaire', orphanRemoval: true)]
    private Collection $forms_satisfaction;

    /**
     * @var Collection<int, fichepresence>
     */
    #[ORM\OneToMany(targetEntity: FichePresence::class, mappedBy: 'stagiaire', orphanRemoval: true)]
    private Collection $fiches_presence;

    #[ORM\ManyToOne(inversedBy: 'stagiaires')]
    private ?Formation $formation = null;

    public function __construct()
    {
        $this->sessions = new ArrayCollection();
        $this->notes = new ArrayCollection();
        $this->forms_satisfaction = new ArrayCollection();
        $this->fiches_presence = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->nom . ' ' . $this->prenom;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }


    public function getDiplome(): ?string
    {
        return $this->diplome;
    }

    public function setDiplome(string $diplome): static
    {
        $this->diplome = $diplome;

        return $this;
    }

    public function isPrerequisValide(): ?bool
    {
        return $this->prerequis_valide;
    }

    public function setPrerequisValide(bool $prerequis_valide): static
    {
        $this->prerequis_valide = $prerequis_valide;

        return $this;
    }

    /**
     * @return Collection<int, Session>
     */
    public function getSessions(): Collection
    {
        return $this->sessions;
    }

    public function addSession(Session $session): static
    {
        if (!$this->sessions->contains($session)) {
            $this->sessions->add($session);
            $session->addStagiaire($this);
        }

        return $this;
    }

    public function removeSession(Session $session): static
    {
        if ($this->sessions->removeElement($session)) {
            $session->removeStagiaire($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, note>
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }

    public function addNote(Note $note): static
    {
        if (!$this->notes->contains($note)) {
            $this->notes->add($note);
            $note->setStagiaire($this);
        }

        return $this;
    }

    public function removeNote(Note $note): static
    {
        if ($this->notes->removeElement($note)) {
            // set the owning side to null (unless already changed)
            if ($note->getStagiaire() === $this) {
                $note->setStagiaire(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, formsatisfaction>
     */
    public function getFormsSatisfaction(): Collection
    {
        return $this->forms_satisfaction;
    }

    public function addFormsSatisfaction(FormSatisfaction $formsSatisfaction): static
    {
        if (!$this->forms_satisfaction->contains($formsSatisfaction)) {
            $this->forms_satisfaction->add($formsSatisfaction);
            $formsSatisfaction->setStagiaire($this);
        }

        return $this;
    }

    public function removeFormsSatisfaction(FormSatisfaction $formsSatisfaction): static
    {
        if ($this->forms_satisfaction->removeElement($formsSatisfaction)) {
            // set the owning side to null (unless already changed)
            if ($formsSatisfaction->getStagiaire() === $this) {
                $formsSatisfaction->setStagiaire(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, fichepresence>
     */
    public function getFichesPresence(): Collection
    {
        return $this->fiches_presence;
    }

    public function addFichesPresence(FichePresence $fichesPresence): static
    {
        if (!$this->fiches_presence->contains($fichesPresence)) {
            $this->fiches_presence->add($fichesPresence);
            $fichesPresence->setStagiaire($this);
        }

        return $this;
    }

    public function removeFichesPresence(FichePresence $fichesPresence): static
    {
        if ($this->fiches_presence->removeElement($fichesPresence)) {
            // set the owning side to null (unless already changed)
            if ($fichesPresence->getStagiaire() === $this) {
                $fichesPresence->setStagiaire(null);
            }
        }

        return $this;
    }

    public function getFormation(): ?formation
    {
        return $this->formation;
    }

    public function setFormation(?formation $formation): static
    {
        $this->formation = $formation;

        return $this;
    }
}
