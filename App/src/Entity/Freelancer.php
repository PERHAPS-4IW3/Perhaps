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
