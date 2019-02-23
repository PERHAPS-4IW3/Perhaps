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

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Projet", inversedBy="listDevis")
     * @ORM\JoinColumn(nullable=false)
     */
    private $projet;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Facture", mappedBy="devis", cascade={"persist", "remove"})
     */
    private $facture;

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

    public function getProjet(): ?Projet
    {
        return $this->projet;
    }

    public function setProjet(?Projet $projet): self
    {
        $this->projet = $projet;

        return $this;
    }

    public function getFacture(): ?Facture
    {
        return $this->facture;
    }

    public function setFacture(Facture $facture): self
    {
        $this->facture = $facture;

        // set the owning side of the relation if necessary
        if ($this !== $facture->getDevis()) {
            $facture->setDevis($this);
        }

        return $this;
    }
}
