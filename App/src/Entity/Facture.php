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
    private $nom_facture;

    /**
     * @ORM\Column(type="float")
     */
    private $Prix_TTC;

    /**
     * @ORM\Column(type="float")
     */
    private $Prix_HT;

    /**
     * @ORM\Column(type="integer")
     */
    private $Nbr_heures;

    /**
     * @ORM\Column(type="float")
     */
    private $Taux_H;

    /**
     * @ORM\Column(type="float")
     */

    private $Autres_charges;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomFacture(): ?string
    {
        return $this->nom_facture;
    }

    public function setNomFacture(string $nom_facture): self
    {
        $this->nom_facture = $nom_facture;

        return $this;
    }

    public function getPrixTTC(): ?int
    {
        return $this->Prix_TTC;
    }

    public function setPrixTTC(int $Prix_TTC): self
    {
        $this->Prix_TTC = $Prix_TTC;

        return $this;
    }

    public function getPrixHT(): ?int
    {
        return $this->Prix_HT;
    }

    public function setPrixHT(int $Prix_HT): self
    {
        $this->Prix_HT = $Prix_HT;

        return $this;
    }

    public function getNbrHeures(): ?int
    {
        return $this->Nbr_heures;
    }

    public function setNbrHeures(int $Nbr_heures): self
    {
        $this->Nbr_heures = $Nbr_heures;

        return $this;
    }

    public function getTauxH(): ?int
    {
        return $this->Taux_H;
    }

    public function setTauxH(int $Taux_H): self
    {
        $this->Taux_H = $Taux_H;

        return $this;
    }


    public function getAutresCharges(): ?float
    {
        return $this->Autres_charges;
    }

    public function setAutresCharges(float $Autres_charges): self
    {
        $this->Autres_charges = $Autres_charges;

        return $this;
    }
}
