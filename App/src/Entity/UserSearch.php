<?php
/**
 * Created by PhpStorm.
 * User: Tounsi
 * Date: 21/04/2019
 * Time: 13:58
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

class UserSearch
{

    /**
     * @var String|null
     */
    private $userProfession;

    /**
     * @var ArrayCollection
     */
    private $listCompetence;

    /**
     * @var String|null
     */
    private $userAnciennete;

    /**
     * @var String|null
     */
    private $userNameAndCompany;

    public function __construct()
    {
        $this->listCompetence = new ArrayCollection();
    }

    /**
     * @return null|String
     */
    public function getUserProfession(): ?String
    {
        return $this->userProfession;
    }

    /**
     * @param null|String $userProfession
     * @return UserSearch
     */
    public function setUserProfession(String $userProfession): UserSearch
    {
        $this->userProfession = $userProfession;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getListCompetence(): ArrayCollection
    {
        return $this->listCompetence;
    }

    /**
     * @param ArrayCollection $listCompetence
     * @return UserSearch
     */
    public function setListCompetence(ArrayCollection $listCompetence): UserSearch
    {
        $this->listCompetence = $listCompetence;
        return $this;
    }

    /**
     * @return null|String
     */
    public function getUserAnciennete(): ?String
    {
        return $this->userAnciennete;
    }

    /**
     * @param null|String $userAnciennete
     * @return UserSearch
     */
    public function setUserAnciennete(String $userAnciennete): UserSearch
    {
        $this->userAnciennete = $userAnciennete;
        return $this;
    }

    /**
     * @return null|String
     */
    public function getUserNameAndCompany(): ?String
    {
        return $this->userNameAndCompany;
    }

    /**
     * @param null|String $userNameAndCompany
     * @return UserSearch
     */
    public function setUserNameAndCompany(String $userNameAndCompany): UserSearch
    {
        $this->userNameAndCompany = $userNameAndCompany;
        return $this;
    }

}