<?php

namespace App\Entity;

use App\Repository\FormationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FormationRepository::class)]
class Formation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $ficheFormation = null;

    /**
     * @var Collection<int, session>
     */
    #[ORM\OneToMany(targetEntity: Session::class, mappedBy: 'formation')]
    private Collection $sessions;

    /**
     * @var Collection<int, Stagiaire>
     */
    #[ORM\OneToMany(targetEntity: Stagiaire::class, mappedBy: 'formation')]
    private Collection $stagiaires;

    /**
     * @var Collection<int, soustheme>
     */
    #[ORM\ManyToMany(targetEntity: soustheme::class, inversedBy: 'formations')]
    private Collection $sousthemes;

    public function __construct()
    {
        $this->sessions = new ArrayCollection();
        $this->stagiaires = new ArrayCollection();
        $this->sousthemes = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->nom;
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

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

    public function getFicheFormation(): ?string
    {
        return $this->ficheFormation;
    }

    public function setFicheFormation(string $ficheFormation): static
    {
        $this->ficheFormation = $ficheFormation;

        return $this;
    }

    /**
     * @return Collection<int, session>
     */
    public function getSessions(): Collection
    {
        return $this->sessions;
    }

    public function addSession(Session $session): static
    {
        if (!$this->sessions->contains($session)) {
            $this->sessions->add($session);
            $session->setFormation($this);
        }

        return $this;
    }

    public function removeSession(Session $session): static
    {
        if ($this->sessions->removeElement($session)) {
            // set the owning side to null (unless already changed)
            if ($session->getFormation() === $this) {
                $session->setFormation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Stagiaire>
     */
    public function getStagiaires(): Collection
    {
        return $this->stagiaires;
    }

    public function addStagiaire(Stagiaire $stagiaire): static
    {
        if (!$this->stagiaires->contains($stagiaire)) {
            $this->stagiaires->add($stagiaire);
            $stagiaire->setFormation($this);
        }

        return $this;
    }

    public function removeStagiaire(Stagiaire $stagiaire): static
    {
        if ($this->stagiaires->removeElement($stagiaire)) {
            // set the owning side to null (unless already changed)
            if ($stagiaire->getFormation() === $this) {
                $stagiaire->setFormation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, soustheme>
     */
    public function getSousthemes(): Collection
    {
        return $this->sousthemes;
    }

    public function addSoustheme(soustheme $soustheme): static
    {
        if (!$this->sousthemes->contains($soustheme)) {
            $this->sousthemes->add($soustheme);
        }

        return $this;
    }

    public function removeSoustheme(soustheme $soustheme): static
    {
        $this->sousthemes->removeElement($soustheme);

        return $this;
    }
}
