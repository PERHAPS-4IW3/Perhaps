<?php
/**
 * Created by PhpStorm.
 * User: Tounsi
 * Date: 15/04/2019
 * Time: 21:03
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;


class ProjetSearch
{
    /**
     * @var String|null
     */
    private $nomProjetSearch;

    /**
     * @var int|null
     * @Assert\Range(min=50, max=100000)
     */
    private $minBudgetSearch;

    /**
     * @var ArrayCollection
     */
    private $typeProjet;

    public function __construct()
    {
        $this->typeProjet = new ArrayCollection();
    }

    /**
     * @return null|String
     */
    public function getNomProjetSearch(): ?String
    {
        return $this->nomProjetSearch;
    }

    /**
     * @param null|String $nomProjetSearch
     * @return ProjetSearch
     */
    public function setNomProjetSearch(String $nomProjetSearch): ProjetSearch
    {
        $this->nomProjetSearch = $nomProjetSearch;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getMinBudgetSearch(): ?int
    {
        return $this->minBudgetSearch;
    }

    /**
     * @param int|null $minBudgetSearch
     * @return ProjetSearch
     */
    public function setMinBudgetSearch(int $minBudgetSearch): ProjetSearch
    {
        $this->minBudgetSearch = $minBudgetSearch;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getTypeProjet(): ArrayCollection
    {
        return $this->typeProjet;
    }

    /**
     * @param ArrayCollection $typeProjet
     * @return ProjetSearch
     */
    public function setTypeProjet(ArrayCollection $typeProjet): ProjetSearch
    {
        $this->typeProjet = $typeProjet;
        return $this;
    }



}