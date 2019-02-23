<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FactureRepository")
 */
class Facture
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nomFacture;

    /**
     * @ORM\Column(type="float")
     */
    private $prixTTC;

    /**
     * @ORM\Column(type="float")
     */
    private $prixHT;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbrHeures;

    /**
     * @ORM\Column(type="float")
     */
    private $tauxH;

    /**
     * @ORM\Column(type="float")
     */

    private $autresCharges;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Projet", inversedBy="facture", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $idProjet;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Devis", inversedBy="facture", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $devis;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomFacture(): ?string
    {
        return $this->nomFacture;
    }

    public function setNomFacture(string $nomFacture): self
    {
        $this->nomFacture = $nomFacture;

        return $this;
    }

    public function getPrixTTC(): ?int
    {
        return $this->prixTTC;
    }

    public function setPrixTTC(int $prixTTC): self
    {
        $this->prixTTC = $prixTTC;

        return $this;
    }

    public function getPrixHT(): ?int
    {
        return $this->prixHT;
    }

    public function setPrixHT(int $prixHT): self
    {
        $this->prixHT = $prixHT;

        return $this;
    }

    public function getNbrHeures(): ?int
    {
        return $this->nbrHeures;
    }

    public function setNbrHeures(int $nbrHeures): self
    {
        $this->nbrHeures = $nbrHeures;

        return $this;
    }

    public function getTauxH(): ?int
    {
        return $this->tauxH;
    }

    public function setTauxH(int $tauxH): self
    {
        $this->tauxH = $tauxH;

        return $this;
    }


    public function getAutresCharges(): ?float
    {
        return $this->autresCharges;
    }

    public function setAutresCharges(float $autresCharges): self
    {
        $this->autresCharges = $autresCharges;

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

    public function getDevis(): ?Devis
    {
        return $this->devis;
    }

    public function setDevis(Devis $devis): self
    {
        $this->devis = $devis;

        return $this;
    }


}
