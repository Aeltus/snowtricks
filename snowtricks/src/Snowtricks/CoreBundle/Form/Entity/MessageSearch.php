<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 25/04/2017
 * Time: 20:55
 */
namespace Snowtricks\CoreBundle\Form\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class MessageSearch {

    private $number = 10;

    /**
     * @Assert\Type(type = "integer", message="Ce champ ne dois pas être modifié.")
     */
    private $firstResult = 0;

    /**=================================================================================================================
    =                                                                                                                 =
    =                                          Getters                                                                =
    =                                                                                                                 =
    ================================================================================================================**/
    /**
     * @return int
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @return int
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
     * @param int $number
     */
    public function setNumber(int $number)
    {
        $this->number = $number;
    }

    /**
     * @param int $firstResult
     */
    public function setFirstResult(int $firstResult)
    {
        $this->firstResult = $firstResult;
    }
}

