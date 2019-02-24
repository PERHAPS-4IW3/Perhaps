<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CompetencePossederRepository")
 */
class CompetencePosseder
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
    private $notation;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="listDesCompetences")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user_Id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Competence", inversedBy="listUser")
     * @ORM\JoinColumn(nullable=false)
     */
    private $competence_Id;


    public function __construct()
    {
        $this->user_ID = new ArrayCollection();
        $this->competence_ID = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNotation(): ?int
    {
        return $this->notation;
    }

    public function setNotation(int $notation): self
    {
        $this->notation = $notation;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->user_Id;
    }

    public function getCompetenceId(): ?Competence
    {
        return $this->competence_Id;
    }

    public function setUserId($user_Id): void
    {
        $this->user_Id = $user_Id;
    }

    public function setCompetenceId($competence_Id): void
    {
        $this->competence_Id = $competence_Id;
    }

}
