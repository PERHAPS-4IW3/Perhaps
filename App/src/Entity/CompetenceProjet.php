<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CompetenceProjetRepository")
 */
class CompetenceProjet
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Projet", inversedBy="listCompetence")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idProjet;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Competence")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idCompetence;

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

    public function getIdCompetence(): ?Competence
    {
        return $this->idCompetence;
    }

    public function setIdCompetence(?Competence $idCompetence): self
    {
        $this->idCompetence = $idCompetence;

        return $this;
    }
}
