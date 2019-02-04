<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Cocur\Slugify\Slugify;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProjetRepository")
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

    public function __construct()
    {
        $this->createdAt = new \DateTime();
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

}
