<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DevisRepository")
 */
class Devis
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $descriptionDevis;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $offreDevis;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $delaiDevis;

    /**
     * @ORM\Column(type="date")
     */
    private $dateDevis;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescriptionDevis(): ?string
    {
        return $this->descriptionDevis;
    }

    public function setDescriptionDevis(string $descriptionDevis): self
    {
        $this->descriptionDevis = $descriptionDevis;

        return $this;
    }

    public function getOffreDevis(): ?int
    {
        return $this->offreDevis;
    }

    public function setOffreDevis(?int $offreDevis): self
    {
        $this->offreDevis = $offreDevis;

        return $this;
    }

    public function getDelaiDevis(): ?int
    {
        return $this->delaiDevis;
    }

    public function setDelaiDevis(?int $delaiDevis): self
    {
        $this->delaiDevis = $delaiDevis;

        return $this;
    }

    public function getDateDevis(): ?\DateTimeInterface
    {
        return $this->dateDevis;
    }

    public function setDateDevis(\DateTimeInterface $dateDevis): self
    {
        $this->dateDevis = $dateDevis;

        return $this;
    }
}
