<?php

namespace App\Entity;

use App\Repository\ThemeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ThemeRepository::class)]
class Theme
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $intitule = null;

    /**
     * @var Collection<int, soustheme>
     */
    #[ORM\OneToMany(targetEntity: SousTheme::class, mappedBy: 'theme', orphanRemoval: true)]
    private Collection $sous_themes;

    /**
     * @var Collection<int, Formation>
     */
    #[ORM\OneToMany(targetEntity: Formation::class, mappedBy: 'theme')]
    private Collection $formations;

    public function __construct()
    {
        $this->sous_themes = new ArrayCollection();
        $this->formations = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->intitule;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIntitule(): ?string
    {
        return $this->intitule;
    }

    public function setIntitule(string $intitule): static
    {
        $this->intitule = $intitule;

        return $this;
    }

    /**
     * @return Collection<int, soustheme>
     */
    public function getSousThemes(): Collection
    {
        return $this->sous_themes;
    }

    public function addSousTheme(soustheme $sousTheme): static
    {
        if (!$this->sous_themes->contains($sousTheme)) {
            $this->sous_themes->add($sousTheme);
            $sousTheme->setTheme($this);
        }

        return $this;
    }

    public function removeSousTheme(soustheme $sousTheme): static
    {
        if ($this->sous_themes->removeElement($sousTheme)) {
            // set the owning side to null (unless already changed)
            if ($sousTheme->getTheme() === $this) {
                $sousTheme->setTheme(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Formation>
     */
    public function getFormations(): Collection
    {
        return $this->formations;
    }

    public function addFormation(Formation $formation): static
    {
        if (!$this->formations->contains($formation)) {
            $this->formations->add($formation);
            $formation->setTheme($this);
        }

        return $this;
    }

    public function removeFormation(Formation $formation): static
    {
        if ($this->formations->removeElement($formation)) {
            // set the owning side to null (unless already changed)
            if ($formation->getTheme() === $this) {
                $formation->setTheme(null);
            }
        }

        return $this;
    }

}
