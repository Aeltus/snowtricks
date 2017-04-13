<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 08/04/2017
 * Time: 10:08
 */
namespace Snowtricks\CoreBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class TrickSearch {

    /**
     * @Assert\Type(type="string", message="La recherche doit être effectutée grâce à une chaine de caractères.")
     */
    private $search = NULL;

    /**
     * @Assert\Choice(choices={"5", "10", "20", "50", "100"}, message="Choisissez un nombre valide dans la liste.")
     */
    private $number = 10;

    /**
     * @Assert\Choice(choices={"title", "created_at", "created_by", "group"}, message="Choisissez un critère de tri valide dans la liste.")
     */
    private $orderedBy = "title";

    /**
     * @Assert\Choice(choices={"asc", "desc"}, message="Choisissez un ordre valide dans la liste.")
     */
    private $order = "ASC";

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
     * @return null
     */
    public function getSearch()
    {
        return $this->search;
    }

    /**
     * @return int
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @return string
     */
    public function getOrderedBy()
    {
        return $this->orderedBy;
    }

    /**
     * @return string
     */
    public function getOrder()
    {
        return $this->order;
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
     * @param null $search
     */
    public function setSearch($search)
    {
        $this->search = $search;
    }

    /**
     * @param int $number
     */
    public function setNumber(int $number)
    {
        $this->number = $number;
    }

    /**
     * @param string $orderedBy
     */
    public function setOrderedBy(string $orderedBy)
    {
        $this->orderedBy = $orderedBy;
    }

    /**
     * @param string $order
     */
    public function setOrder(string $order)
    {
        $this->order = $order;
    }

    /**
     * @param int $firstResult
     */
    public function setFirstResult(int $firstResult)
    {
        $this->firstResult = $firstResult;
    }
}
