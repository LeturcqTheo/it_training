<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestionRepository::class)]
class Question
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $intitule = null;

    #[ORM\Column]
    private ?bool $est_choix_multiple = null;

    #[ORM\ManyToOne(inversedBy: 'questions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Evaluation $evaluation = null;

    /**
     * @var Collection<int, reponse>
     */
    #[ORM\OneToMany(targetEntity: Reponse::class, cascade: ['persist'], mappedBy: 'question', orphanRemoval: true)]
    private Collection $responses;

    public function __construct()
    {
        $this->responses = new ArrayCollection();
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

    public function isEstChoixMultiple(): ?bool
    {
        return $this->est_choix_multiple;
    }

    public function setEstChoixMultiple(bool $est_choix_multiple): static
    {
        $this->est_choix_multiple = $est_choix_multiple;

        return $this;
    }

    public function getEvaluation(): ?Evaluation
    {
        return $this->evaluation;
    }

    public function setEvaluation(?Evaluation $evaluation): static
    {
        $this->evaluation = $evaluation;

        return $this;
    }

    /**
     * @return Collection<int, reponse>
     */
    public function getResponses(): Collection
    {
        return $this->responses;
    }

    public function addResponse(Reponse $response): static
    {
        if (!$this->responses->contains($response)) {
            $this->responses->add($response);
            $response->setQuestion($this);
        }

        return $this;
    }

    public function removeResponse(Reponse $response): static
    {
        if ($this->responses->removeElement($response)) {
            // set the owning side to null (unless already changed)
            if ($response->getQuestion() === $this) {
                $response->setQuestion(null);
            }
        }

        return $this;
    }
}
