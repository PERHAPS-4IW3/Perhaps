<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NoteEtCommentaireRepository")
 * @UniqueEntity(fields={"idProje","developpeur"},
 *      errorPath =  "developpeur",
 *      message="Le developpeur a déjà été noter pour ce projet")
 */
class NoteEtCommentaire
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $note;

    /**
     * @ORM\Column(type="string", length=300)
     */
    private $commentaire;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Projet", inversedBy="listCommentaireEtNote")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idProjet;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\user", inversedBy="noteEtCommentaire")
     * @ORM\JoinColumn(nullable=false)
     */
    private $developpeur;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNote(): ?float
    {
        return $this->note;
    }

    public function setNote(float $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getIdProjet(): ?Projet
    {
        return $this->idProjet;
    }

    public function setIdProjet(Projet $idProjet): self
    {
        $this->idProjet = $idProjet;
        return $this;
    }


    public function getDeveloppeur(): ?user
    {
        return $this->developpeur;
    }

    public function setDeveloppeur(?user $developpeur): self
    {
        $this->developpeur = $developpeur;

        return $this;
    }

}
