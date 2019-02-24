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
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="participe")
     */
    private $listParticipants;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="equipeGerer")
     * @ORM\JoinColumn(nullable=false)
     */
    private $chefDeProjet;

    public function __construct()
    {
        $this->listParticipants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdProjet(): ?Projet
    {
        return $this->idProjet;
    }


    /**
     * @param mixed $idProjet
     */
    public function setIdProjet($idProjet): void
    {
        $this->idProjet = $idProjet;
    }

    public function addListParticipant(Participe $listParticipant): self
    {
        if (!$this->listParticipants->contains($listParticipant)) {
            $this->listParticipants[] = $listParticipant;
        }

        return $this;
    }

    public function removeListParticipant(Participe $listParticipant): self
    {
        if ($this->listParticipants->contains($listParticipant)) {
            $this->listParticipants->removeElement($listParticipant);
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getListParticipants(): Collection
    {
        return $this->listParticipants;
    }

    public function getChefDeProjet(): ?User
    {
        return $this->chefDeProjet;
    }

    public function setChefDeProjet(?User $chefDeProjet): self
    {
        $this->chefDeProjet = $chefDeProjet;

        return $this;
    }
}
