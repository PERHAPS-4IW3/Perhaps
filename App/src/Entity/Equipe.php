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
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="equipeGerer")
     * @ORM\JoinColumn(nullable=false)
     */
    private $chefDeProjet;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="participe")
     */
    private $listParticipants;


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

    public function setIdProjet(?Projet $idProjet): self
    {
         $this->idProjet =$idProjet ;
        return $this;
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

    /**
     * @return Collection|User[]
     */
    public function getListParticipants(): Collection
    {
        return $this->listParticipants;
    }

    public function addListParticipant(User $listParticipant): self
    {
        if (!$this->listParticipants->contains($listParticipant)) {
            $this->listParticipants[] = $listParticipant;
            $listParticipant->addParticipe($this);
        }

        return $this;
    }

    public function removeListParticipant(User $listParticipant): self
    {
        if ($this->listParticipants->contains($listParticipant)) {
            $this->listParticipants->removeElement($listParticipant);
            $listParticipant->removeParticipe($this);
        }

        return $this;
    }

}
