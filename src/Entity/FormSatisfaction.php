<?php

namespace App\Entity;

use App\Repository\FormSatisfactionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FormSatisfactionRepository::class)]
class FormSatisfaction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $note_satisfaction = null;

    #[ORM\Column]
    private ?int $note_clarete = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $problemes = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $suggestions = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $date = null;

    #[ORM\ManyToOne(inversedBy: 'forms_satisfaction')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Stagiaire $stagiaire = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNoteSatisfaction(): ?int
    {
        return $this->note_satisfaction;
    }

    public function setNoteSatisfaction(int $note_satisfaction): static
    {
        $this->note_satisfaction = $note_satisfaction;

        return $this;
    }

    public function getNoteClarete(): ?int
    {
        return $this->note_clarete;
    }

    public function setNoteClarete(int $note_clarete): static
    {
        $this->note_clarete = $note_clarete;

        return $this;
    }

    public function getProblemes(): ?string
    {
        return $this->problemes;
    }

    public function setProblemes(?string $problemes): static
    {
        $this->problemes = $problemes;

        return $this;
    }

    public function getSuggestions(): ?string
    {
        return $this->suggestions;
    }

    public function setSuggestions(?string $suggestions): static
    {
        $this->suggestions = $suggestions;

        return $this;
    }

    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): static
    {
        $this->date = $date;

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
