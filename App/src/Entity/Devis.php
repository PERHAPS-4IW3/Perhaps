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
    private $description_devis;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $offre_devis;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $delai_devis;

    /**
     * @ORM\Column(type="date")
     */
    private $date_devis;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescriptionDevis(): ?string
    {
        return $this->description_devis;
    }

    public function setDescriptionDevis(string $description_devis): self
    {
        $this->description_devis = $description_devis;

        return $this;
    }

    public function getOffreDevis(): ?int
    {
        return $this->offre_devis;
    }

    public function setOffreDevis(?int $offre_devis): self
    {
        $this->offre_devis = $offre_devis;

        return $this;
    }

    public function getDelaiDevis(): ?int
    {
        return $this->delai_devis;
    }

    public function setDelaiDevis(?int $delai_devis): self
    {
        $this->delai_devis = $delai_devis;

        return $this;
    }

    public function getDateDevis(): ?\DateTimeInterface
    {
        return $this->date_devis;
    }

    public function setDateDevis(\DateTimeInterface $date_devis): self
    {
        $this->date_devis = $date_devis;

        return $this;
    }
}
