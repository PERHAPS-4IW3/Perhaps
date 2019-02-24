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


    public function getIdCompetence(): ?Competence
    {
        return $this->idCompetence;
    }

    /**
     * @param mixed $idProjet
     */
    public function setIdProjet($idProjet): void
    {
        $this->idProjet = $idProjet;
    }

    /**
     * @param mixed $idCompetence
     */
    public function setIdCompetence($idCompetence): void
    {
        $this->idCompetence = $idCompetence;
    }



}
