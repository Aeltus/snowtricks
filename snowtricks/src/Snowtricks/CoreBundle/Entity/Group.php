<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 01/04/2017
 * Time: 18:17
 */
namespace Snowtricks\CoreBundle\Entity\Group;

use Doctrine\ORM\Mapping as ORM;

/**
 * @Package Snowtricks\CoreBundle\Entity
 *
 * @ORM\Table(name="snow_group")
 * @ORM\Entity(repositoryClass="Snowtricks\CoreBundle\Repository\GroupRepository")
 */
class Group {
    /**
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     */
    private $id = 0;
    /**
     * @ORM\Column(name="name", type="string", nullable=false)
     *
     */
    private $name = "";

    public function __construct($id = NULL, $message)
    {
        $this->id = $id;
        $this->name = $name;
    }
    /**=================================================================================================================
    =                                                                                                                 =
    =                                          Getters                                                                =
    =                                                                                                                 =
    ================================================================================================================**/
    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**=================================================================================================================
    =                                                                                                                 =
    =                                          Setters                                                                =
    =                                                                                                                 =
    ================================================================================================================**/
    /**
     * @param int|null $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
}
