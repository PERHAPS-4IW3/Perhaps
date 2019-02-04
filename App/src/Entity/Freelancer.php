<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
    private $nomFreelancer;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $prenomFreelancer;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $emailFreelancer;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $passwordFreelancer;

    /**
     * @ORM\Column(type="string", length=200)
     */
    private $adresseFreelancer;

    /**
     * @ORM\Column(type="string", length=5)
     * @Assert\Regex("/^[0-9]{5}$/")
     */
    private $cpFreelancer;

    /**
     * @ORM\Column(type="string", length=150)
     *
     */
    private $villeFreelancer;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $paysFreelancer;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $phoneFreelancer;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $statutFreelancer;

    /**
     * @ORM\Column(type="integer")
     */
    private $tarifHoraireFreelancer;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $presentationFreelancer;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $nomSocieteFreelancer;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomFreelancer(): ?string
    {
        return $this->nomFreelancer;
    }

    public function setNomFreelancer(string $nomFreelancer): self
    {
        $this->nomFreelancer = $nomFreelancer;

        return $this;
    }

    public function getPrenomFreelancer(): ?string
    {
        return $this->prenomFreelancer;
    }

    public function setPrenomFreelancer(string $prenomFreelancer): self
    {
        $this->prenomFreelancer = $prenomFreelancer;

        return $this;
    }

    public function getEmailFreelancer(): ?string
    {
        return $this->emailFreelancer;
    }

    public function setEmailFreelancer(string $emailFreelancer): self
    {
        $this->emailFreelancer = $emailFreelancer;

        return $this;
    }

    public function getPasswordFreelancer(): ?string
    {
        return $this->passwordFreelancer;
    }

    public function setPasswordFreelancer(string $passwordFreelancer): self
    {
        $this->passwordFreelancer = $passwordFreelancer;

        return $this;
    }

    public function getAdresseFreelancer(): ?string
    {
        return $this->adresseFreelancer;
    }

    public function setAdresseFreelancer(string $adresseFreelancer): self
    {
        $this->adresseFreelancer = $adresseFreelancer;

        return $this;
    }

    public function getCpFreelancer(): ?string
    {
        return $this->cpFreelancer;
    }

    public function setCpFreelancer(string $cpFreelancer): self
    {
        $this->cpFreelancer = $cpFreelancer;

        return $this;
    }

    public function getVilleFreelancer(): ?string
    {
        return $this->villeFreelancer;
    }

    public function setVilleFreelancer(string $villeFreelancer): self
    {
        $this->villeFreelancer = $villeFreelancer;

        return $this;
    }

    public function getPaysFreelancer(): ?string
    {
        return $this->paysFreelancer;
    }

    public function setPaysFreelancer(string $paysFreelancer): self
    {
        $this->paysFreelancer = $paysFreelancer;

        return $this;
    }

    public function getPhoneFreelancer(): ?string
    {
        return $this->phoneFreelancer;
    }

    public function setPhoneFreelancer(string $phoneFreelancer): self
    {
        $this->phoneFreelancer = $phoneFreelancer;

        return $this;
    }

    public function getStatutFreelancer(): ?string
    {
        return $this->statutFreelancer;
    }

    public function setStatutFreelancer(string $statutFreelancer): self
    {
        $this->statutFreelancer = $statutFreelancer;

        return $this;
    }

    public function getTarifHoraireFreelancer(): ?int
    {
        return $this->tarifHoraireFreelancer;
    }

    public function setTarifHoraireFreelancer(int $tarifHoraireFreelancer): self
    {
        $this->tarifHoraireFreelancer = $tarifHoraireFreelancer;

        return $this;
    }

    public function getPresentationFreelancer(): ?string
    {
        return $this->presentationFreelancer;
    }

    public function setPresentationFreelancer(string $presentationFreelancer): self
    {
        $this->presentationFreelancer = $presentationFreelancer;

        return $this;
    }

    public function getNomSocieteFreelancer(): ?string
    {
        return $this->nomSocieteFreelancer;
    }

    public function setNomSocieteFreelancer(string $nomSocieteFreelancer): self
    {
        $this->nomSocieteFreelancer = $nomSocieteFreelancer;

        return $this;
    }
}
