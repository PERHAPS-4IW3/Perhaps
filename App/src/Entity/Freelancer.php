<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FreelancerRepository")
 */
class Freelancer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $nom_freelancer;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $prenom_freelancer;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email_freelancer;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password_freelancer;

    /**
     * @ORM\Column(type="string", length=200)
     */
    private $adresse_freelancer;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $cp_freelancer;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $ville_freelancer;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $pays_freelancer;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $phone_freelancer;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $statut_freelancer;

    /**
     * @ORM\Column(type="integer")
     */
    private $tarif_horaire_freelancer;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $presentation_freelancer;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $nom_societe_freelancer;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomFreelancer(): ?string
    {
        return $this->nom_freelancer;
    }

    public function setNomFreelancer(string $nom_freelancer): self
    {
        $this->nom_freelancer = $nom_freelancer;

        return $this;
    }

    public function getPrenomFreelancer(): ?string
    {
        return $this->prenom_freelancer;
    }

    public function setPrenomFreelancer(string $prenom_freelancer): self
    {
        $this->prenom_freelancer = $prenom_freelancer;

        return $this;
    }

    public function getEmailFreelancer(): ?string
    {
        return $this->email_freelancer;
    }

    public function setEmailFreelancer(string $email_freelancer): self
    {
        $this->email_freelancer = $email_freelancer;

        return $this;
    }

    public function getPasswordFreelancer(): ?string
    {
        return $this->password_freelancer;
    }

    public function setPasswordFreelancer(string $password_freelancer): self
    {
        $this->password_freelancer = $password_freelancer;

        return $this;
    }

    public function getAdresseFreelancer(): ?string
    {
        return $this->adresse_freelancer;
    }

    public function setAdresseFreelancer(string $adresse_freelancer): self
    {
        $this->adresse_freelancer = $adresse_freelancer;

        return $this;
    }

    public function getCpFreelancer(): ?string
    {
        return $this->cp_freelancer;
    }

    public function setCpFreelancer(string $cp_freelancer): self
    {
        $this->cp_freelancer = $cp_freelancer;

        return $this;
    }

    public function getVilleFreelancer(): ?string
    {
        return $this->ville_freelancer;
    }

    public function setVilleFreelancer(string $ville_freelancer): self
    {
        $this->ville_freelancer = $ville_freelancer;

        return $this;
    }

    public function getPaysFreelancer(): ?string
    {
        return $this->pays_freelancer;
    }

    public function setPaysFreelancer(string $pays_freelancer): self
    {
        $this->pays_freelancer = $pays_freelancer;

        return $this;
    }

    public function getPhoneFreelancer(): ?string
    {
        return $this->phone_freelancer;
    }

    public function setPhoneFreelancer(string $phone_freelancer): self
    {
        $this->phone_freelancer = $phone_freelancer;

        return $this;
    }

    public function getStatutFreelancer(): ?string
    {
        return $this->statut_freelancer;
    }

    public function setStatutFreelancer(string $statut_freelancer): self
    {
        $this->statut_freelancer = $statut_freelancer;

        return $this;
    }

    public function getTarifHoraireFreelancer(): ?int
    {
        return $this->tarif_horaire_freelancer;
    }

    public function setTarifHoraireFreelancer(int $tarif_horaire_freelancer): self
    {
        $this->tarif_horaire_freelancer = $tarif_horaire_freelancer;

        return $this;
    }

    public function getPresentationFreelancer(): ?string
    {
        return $this->presentation_freelancer;
    }

    public function setPresentationFreelancer(string $presentation_freelancer): self
    {
        $this->presentation_freelancer = $presentation_freelancer;

        return $this;
    }

    public function getNomSocieteFreelancer(): ?string
    {
        return $this->nom_societe_freelancer;
    }

    public function setNomSocieteFreelancer(string $nom_societe_freelancer): self
    {
        $this->nom_societe_freelancer = $nom_societe_freelancer;

        return $this;
    }
}
