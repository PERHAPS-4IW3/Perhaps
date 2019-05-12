<?php
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * @ORM\Entity(repositoryClass="App\Repository\CompetenceRepository")
 * @UniqueEntity(fields="nomCompetence",
 *      message="Cette compétence existe deja")
 */
class Competence
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomCompetence;
    public function __construct()
    {
    }
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getNomCompetence(): ?string
    {
        return $this->nomCompetence;
    }
    public function setNomCompetence(string $nomCompetence): self
    {
        $this->nomCompetence = $nomCompetence;
        return $this;
    }
}