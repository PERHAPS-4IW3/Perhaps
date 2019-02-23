<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EquipeRepository")
 */
class Equipe
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Projet", inversedBy="listDesEquipes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idProjet;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $idChefProjet;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Participe", mappedBy="idEquipe", orphanRemoval=true)
     */
    private $listParticipant;

    public function __construct()
    {
        $this->listParticipant = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdProjet(): ?Projet
    {
        return $this->idProjet;
    }

    public function setIdProjet(?Projet $idProjet): self
    {
        $this->idProjet = $idProjet;

        return $this;
    }

    public function getIdChefProjet(): ?User
    {
        return $this->idChefProjet;
    }

    public function setIdChefProjet(User $idChefProjet): self
    {
        $this->idChefProjet = $idChefProjet;

        return $this;
    }

    /**
     * @return Collection|Participe[]
     */
    public function getListParticipant(): Collection
    {
        return $this->listParticipant;
    }

    public function addListParticipant(Participe $listParticipant): self
    {
        if (!$this->listParticipant->contains($listParticipant)) {
            $this->listParticipant[] = $listParticipant;
            $listParticipant->setIdEquipe($this);
        }

        return $this;
    }

    public function removeListParticipant(Participe $listParticipant): self
    {
        if ($this->listParticipant->contains($listParticipant)) {
            $this->listParticipant->removeElement($listParticipant);
            // set the owning side to null (unless already changed)
            if ($listParticipant->getIdEquipe() === $this) {
                $listParticipant->setIdEquipe(null);
            }
        }

        return $this;
    }
}
