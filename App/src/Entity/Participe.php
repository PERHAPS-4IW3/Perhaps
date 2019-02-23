<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ParticipeRepository")
 */
class Participe
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="listProjet")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idUser;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Equipe", inversedBy="listParticipant")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idEquipe;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\NoteEtCommentaire", mappedBy="idParticipant", cascade={"persist", "remove"})
     */
    private $commentaire;


    public function __construct()
    {
        $this->listCommentaire = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUser(): ?User
    {
        return $this->idUser;
    }

    public function setIdUser(?User $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }

    public function getIdEquipe(): ?Equipe
    {
        return $this->idEquipe;
    }

    public function setIdEquipe(?Equipe $idEquipe): self
    {
        $this->idEquipe = $idEquipe;

        return $this;
    }

    public function getCommentaire(): ?NoteEtCommentaire
    {
        return $this->commentaire;
    }

    public function setCommentaire(NoteEtCommentaire $commentaire): self
    {
        $this->commentaire = $commentaire;

        // set the owning side of the relation if necessary
        if ($this !== $commentaire->getIdParticipant()) {
            $commentaire->setIdParticipant($this);
        }

        return $this;
    }
}