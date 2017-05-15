<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 25/04/2017
 * Time: 20:55
 */
namespace Snowtricks\CoreBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;

class MessageSearch {

    private $number = 10;

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
    public function setNumber($number)
    {
        $this->number = $number;
    }

    /**
     * @param int $firstResult
     */
    public function setFirstResult($firstResult)
    {
        $this->firstResult = $firstResult;
    }
}

