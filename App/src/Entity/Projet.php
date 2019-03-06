<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Cocur\Slugify\Slugify;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProjetRepository")
 * @ORM\Table(name="projet")
 */
class Projet
{
    const CONTACT = [
        0 => 'Email',
        1 => 'Téléphone'
    ];

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\Length(min=3, max=50)
     */
    private $nomProjet;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(min=30)
     */
    private $descriptionProjet;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(min=100, max=100000)
     */
    private $budget;


    /**
     * @ORM\Column(type="date")
     * @Assert\GreaterThan("today")
     */
    private $dateDebut;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="boolean", options={"default" : true})
     */
    private $isVisible = true;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $choixContact;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Facture", mappedBy="idProjet", cascade={"persist", "remove"})
     */
    private $facture;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Equipe", mappedBy="idProjet", orphanRemoval=true)
     */
    private $listDesEquipes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\NoteEtCommentaire", mappedBy="idProjet", orphanRemoval=true)
     */
    private $listCommentaireEtNote;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Devis", mappedBy="projet", orphanRemoval=true)
     */
    private $listDevis;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="projetGerer")
     * @ORM\JoinColumn(nullable=false)
     */
    private $creePar;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Competence")
     */
    private $listCompetence;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\TypeProjet", inversedBy="projets", cascade={"persist"})
     */
    private $typeProjet;



    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->listDesEquipes = new ArrayCollection();
        $this->listCommentaireEtNote = new ArrayCollection();
        $this->listDevis = new ArrayCollection();
        $this->listCompetence = new ArrayCollection();
        $this->typeProjet = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomProjet(): ?string
    {
        return $this->nomProjet;
    }

    public function setNomProjet(string $nomProjet): self
    {
        $this->nomProjet = $nomProjet;

        return $this;
    }

    //Fonction Slug - Convertir un string en slug
    public function getSlug(): string
    {
        return (new Slugify())->slugify($this->nomProjet);
    }

    public function getDescriptionProjet(): ?string
    {
        return $this->descriptionProjet;
    }

    public function setDescriptionProjet(string $descriptionProjet): self
    {
        $this->descriptionProjet = $descriptionProjet;

        return $this;
    }

    public function getBudget(): ?int
    {
        return $this->budget;
    }

    public function setBudget(int $budget): self
    {
        $this->budget = $budget;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getIsVisible(): ?bool
    {
        return $this->isVisible;
    }

    public function setIsVisible(bool $isVisible): self
    {
        $this->isVisible = $isVisible;

        return $this;
    }

    public function getChoixContact(): ?int
    {
        return $this->choixContact;
    }

    public function setChoixContact(?int $choixContact): self
    {
        $this->choixContact = $choixContact;

        return $this;
    }

    public function getChoixContactType(): string
    {
        return self::CONTACT[$this->choixContact];
    }



    public function getFacture(): ?Facture
    {
        return $this->facture;
    }

    public function setFacture(Facture $facture): self
    {
        $this->facture = $facture;

        // set the owning side of the relation if necessary
        if ($this !== $facture->getIdProjet()) {
            $facture->setIdProjet($this);
        }

        return $this;
    }

    /**
     * @return Collection|Equipe[]
     */
    public function getListDesEquipes(): Collection
    {
        return $this->listDesEquipes;
    }

    public function addListDesEquipe(Equipe $listDesEquipe): self
    {
        if (!$this->listDesEquipes->contains($listDesEquipe)) {
            $this->listDesEquipes[] = $listDesEquipe;
            $listDesEquipe->setIdProjet($this);
        }

        return $this;
    }

    public function removeListDesEquipe(Equipe $listDesEquipe): self
    {
        if ($this->listDesEquipes->contains($listDesEquipe)) {
            $this->listDesEquipes->removeElement($listDesEquipe);
            // set the owning side to null (unless already changed)
            if ($listDesEquipe->getIdProjet() === $this) {
                $listDesEquipe->setIdProjet(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|NoteEtCommentaire[]
     */
    public function getListCommentaireEtNote(): Collection
    {
        return $this->listCommentaireEtNote;
    }

    public function addListCommentaireEtNote(NoteEtCommentaire $listCommentaireEtNote): self
    {
        if (!$this->listCommentaireEtNote->contains($listCommentaireEtNote)) {
            $this->listCommentaireEtNote[] = $listCommentaireEtNote;
            $listCommentaireEtNote->setIdProjet($this);
        }

        return $this;
    }

    public function removeListCommentaireEtNote(NoteEtCommentaire $listCommentaireEtNote): self
    {
        if ($this->listCommentaireEtNote->contains($listCommentaireEtNote)) {
            $this->listCommentaireEtNote->removeElement($listCommentaireEtNote);
            // set the owning side to null (unless already changed)
            if ($listCommentaireEtNote->getIdProjet() === $this) {
                $listCommentaireEtNote->setIdProjet(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Devis[]
     */
    public function getListDevis(): Collection
    {
        return $this->listDevis;
    }

    public function addListDevi(Devis $listDevi): self
    {
        if (!$this->listDevis->contains($listDevi)) {
            $this->listDevis[] = $listDevi;
            $listDevi->setProjet($this);
        }

        return $this;
    }

    public function removeListDevi(Devis $listDevi): self
    {
        if ($this->listDevis->contains($listDevi)) {
            $this->listDevis->removeElement($listDevi);
            // set the owning side to null (unless already changed)
            if ($listDevi->getProjet() === $this) {
                $listDevi->setProjet(null);
            }
        }

        return $this;
    }

    public function getCreePar(): ?User
    {
        return $this->creePar;
    }

    public function setCreePar(?User $creePar): self
    {
        $this->creePar = $creePar;

        return $this;
    }

    /**
     * @return Collection|Competence[]
     */
    public function getListCompetence(): Collection
    {
        return $this->listCompetence;
    }

    public function addListCompetence(Competence $listCompetence): self
    {
        if (!$this->listCompetence->contains($listCompetence)) {
            $this->listCompetence[] = $listCompetence;
        }

        return $this;
    }

    public function removeListCompetence(Competence $listCompetence): self
    {
        if ($this->listCompetence->contains($listCompetence)) {
            $this->listCompetence->removeElement($listCompetence);
        }

        return $this;
    }

    /**
     * @return Collection|TypeProjet[]
     */
    public function getTypeProjet(): Collection
    {
        return $this->typeProjet;
    }

    public function addTypeProjet(TypeProjet $typeProjet): self
    {
        if (!$this->typeProjet->contains($typeProjet)) {
            $this->typeProjet[] = $typeProjet;
        }

        return $this;
    }

    public function removeTypeProjet(TypeProjet $typeProjet): self
    {
        if ($this->typeProjet->contains($typeProjet)) {
            $this->typeProjet->removeElement($typeProjet);
        }

        return $this;
    }


}
