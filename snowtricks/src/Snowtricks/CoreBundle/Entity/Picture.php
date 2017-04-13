<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 01/04/2017
 * Time: 16:52
 */

namespace Snowtricks\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Snowtricks\CoreBundle\Entity\User;

/**
 *
 * @ORM\Table(name="snow_picture")
 * @ORM\Entity(repositoryClass="Snowtricks\CoreBundle\Repository\PictureRepository")
 */
class Picture {
    /**
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     */
    private $id = 0;
    /**
     * @ORM\Column(name="address", type="string", nullable=false)
     *
     */
    private $address = "";
    /**
     * @ORM\Column(name="created_at", type="datetime")
     *
     */
    private $created_at;
    /**
     * @ORM\ManyToOne(targetEntity="Snowtricks\CoreBundle\Entity\User", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     *
     */
    private $created_by;

    public function __construct($id = NULL, $address,\DateTime $created_at,User $created_by)
    {
        $this->id = $id;
        $this->address = $address;
        $this->created_by = $created_by;
        $this->created_at = $created_at;
    }
    /**=================================================================================================================
    =                                                                                                                 =
    =                                          Getters                                                                =
    =                                                                                                                 =
    ================================================================================================================**/
    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @return \User
     */
    public function getCreatedBy()
    {
        return $this->created_by;
    }
    /**=================================================================================================================
    =                                                                                                                 =
    =                                          Setters                                                                =
    =                                                                                                                 =
    ================================================================================================================**/
    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @param \DateTime $created_at
     */
    public function setCreatedAt(\DateTime $created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * @param \User $created_by
     */
    public function setCreatedBy(User $created_by)
    {
        $this->created_by = $created_by;
    }

}
