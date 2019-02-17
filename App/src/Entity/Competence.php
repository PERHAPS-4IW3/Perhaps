<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CompetenceRepository")
 */
class Competence
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomCompetence;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CompetencePosseder", mappedBy="competence_Id", orphanRemoval=true)
     */
    private $listUser;

    public function __construct()
    {
        $this->listUser = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomCompetence(): ?string
    {
        return $this->nomCompetence;
    }

    public function setNomCompetence(string $nomCompetence): self
    {
        $this->nomCompetence = $nomCompetence;

        return $this;
    }

    /**
     * @return Collection|CompetencePosseder[]
     */
    public function getListUser(): Collection
    {
        return $this->listUser;
    }

    public function addListUser(CompetencePosseder $listUser): self
    {
        if (!$this->listUser->contains($listUser)) {
            $this->listUser[] = $listUser;
            $listUser->setCompetenceId($this);
        }

        return $this;
    }

    public function removeListUser(CompetencePosseder $listUser): self
    {
        if ($this->listUser->contains($listUser)) {
            $this->listUser->removeElement($listUser);
            // set the owning side to null (unless already changed)
            if ($listUser->getCompetenceId() === $this) {
                $listUser->setCompetenceId(null);
            }
        }

        return $this;
    }


}
