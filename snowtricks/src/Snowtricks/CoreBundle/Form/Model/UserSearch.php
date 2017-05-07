<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 06/05/2017
 * Time: 17:23
 */
namespace Snowtricks\CoreBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;

class UserSearch {

    /**
     * @Assert\Type(type="string", message="La recherche du nom doit être effectutée grâce à une chaine de caractères.")
     */
    private $searchName = NULL;

    /**
     * @Assert\Type(type="string", message="La recherche du prénom doit être effectutée grâce à une chaine de caractères.")
     */
    private $searchSurname = NULL;

    /**
     * @Assert\Type(type="digit", message="Ce champ ne dois pas être modifié.")
     */
    private $firstResult = 0;

    /**=================================================================================================================
    =                                                                                                                 =
    =                                          Getters                                                                =
    =                                                                                                                 =
    ================================================================================================================**/
    /**
     * @return mixed
     */
    public function getSearchName()
    {
        return $this->searchName;
    }

    /**
     * @return mixed
     */
    public function getSearchSurname()
    {
        return $this->searchSurname;
    }

    /**
     * @return mixed
     */
    public function getFirstResult()
    {
        return $this->firstResult;
    }
    /**=================================================================================================================
    =                                                                                                                 =
    =                                          Setters                                                                =
    =                                                                                                                 =
    ================================================================================================================**/
    /**
     * @param mixed $searchName
     */
    public function setSearchName($searchName)
    {
        $this->searchName = $searchName;
        return $this;
    }

    /**
     * @param mixed $searchSurname
     */
    public function setSearchSurname($searchSurname)
    {
        $this->searchSurname = $searchSurname;
        return $this;
    }

    /**
     * @param mixed $firstResult
     */
    public function setFirstResult($firstResult)
    {
        $this->firstResult = $firstResult;
        return $this;
    }
}

