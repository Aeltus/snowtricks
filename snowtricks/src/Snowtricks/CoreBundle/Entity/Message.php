<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 01/04/2017
 * Time: 18:10
 */
namespace Snowtricks\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Snowtricks\CoreBundle\Entity\Trick;
use Snowtricks\CoreBundle\Entity\User;

/**
 *
 * @ORM\Table(name="snow_message")
 * @ORM\Entity(repositoryClass="Snowtricks\CoreBundle\Repository\MessageRepository")
 */
class Message {
    /**
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     */
    private $id = 0;
    /**
     * @ORM\ManyToOne(targetEntity="Snowtricks\CoreBundle\Entity\Trick", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $trick;
    /**
     * @ORM\ManyToOne(targetEntity="Snowtricks\CoreBundle\Entity\User", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $created_by;
    /**
     * @ORM\Column(name="message", type="string")
     *
     */
    private $message = "";
    /**
     * @ORM\Column(name="created_at", type="datetime")
     *
     */
    private $created_at;

    public function __construct($id = NULL,Trick $trick,User $created_by, $message,\DateTime $created_at)
    {
        $this->id = $id;
        $this->trick = $trick;
        $this->created_by = $created_by;
        $this->message = $message;
        $this->created_at = $created_at;
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
     * @return Trick
     */
    public function getTrick()
    {
        return $this->trick;
    }

    /**
     * @return User
     */
    public function getCreatedBy()
    {
        return $this->created_by;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
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
     * @param Trick $trick
     */
    public function setTrick(Trick $trick)
    {
        $this->trick = $trick;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @param \DateTime $created_at
     */
    public function setCreatedAt(\DateTime $created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * @param User $created_by
     */
    public function setCreatedBy(User $created_by)
    {
        $this->created_by = $created_by;
    }
}
