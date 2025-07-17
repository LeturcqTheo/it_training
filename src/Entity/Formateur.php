<?php

namespace App\Entity;

use App\Repository\FormateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FormateurRepository::class)]
class Formateur extends User
{
    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $cv = null;

    #[ORM\Column]
    private ?bool $est_valide = null;

    /**
     * @var Collection<int, Affecte>
     */
    #[ORM\OneToMany(targetEntity: Affecte::class, mappedBy: 'formateur')]
    private Collection $affectes;

    public function __construct()
    {
        $this->affectes = new ArrayCollection();
        $this->setRoles(["ROLE_FORMATEUR"]);
    }

    public function __toString(): string
    {
        return $this->nom . ' ' . $this->prenom;
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

    public function getCv(): ?string
    {
        return $this->cv;
    }

    public function setCv(string $cv): static
    {
        $this->cv = $cv;

        return $this;
    }

    public function isEstValide(): ?bool
    {
        return $this->est_valide;
    }

    public function setEstValide(bool $est_valide): static
    {
        $this->est_valide = $est_valide;

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
            $affecte->setFormateur($this);
        }

        return $this;
    }

    public function removeAffecte(Affecte $affecte): static
    {
        if ($this->affectes->removeElement($affecte)) {
            // set the owning side to null (unless already changed)
            if ($affecte->getFormateur() === $this) {
                $affecte->setFormateur(null);
            }
        }

        return $this;
    }
}
