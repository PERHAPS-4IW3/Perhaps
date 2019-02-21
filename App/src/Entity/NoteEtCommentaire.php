<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NoteEtCommentaireRepository")
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
     * @ORM\OneToOne(targetEntity="App\Entity\Participe", inversedBy="commentaire", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $idParticipant;


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

    public function setIdProjet(?Projet $idProjet): self
    {
        $this->idProjet = $idProjet;

        return $this;
    }

    public function getIdParticipant(): ?Participe
    {
        return $this->idParticipant;
    }

    public function setIdParticipant(Participe $idParticipant): self
    {
        $this->idParticipant = $idParticipant;

        return $this;
    }

}
