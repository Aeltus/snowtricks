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
use Symfony\Component\Validator\Constraints as Assert;

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
     * @ORM\ManyToOne(targetEntity="Snowtricks\CoreBundle\Entity\Trick")
     * @ORM\JoinColumn(nullable=false)
     */
    private $trick;
    /**
     * @ORM\ManyToOne(targetEntity="Snowtricks\CoreBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $createdBy;
    /**
     * @ORM\Column(name="message", type="string")
     *
     * @Assert\Length(min=3, minMessage="Un message de moins de {{ limit }} caractères, ce n'est pas sérieux...", groups={"Default"})
     * @Assert\Length(max=255, maxMessage="Le message doit faire au maximum {{ limit }} caractères.", groups={"Default"})
     * @Assert\NotBlank(message="Vous devez inscrire un message avant de valider.", groups={"Default"})
     * @Assert\Type("string", groups={"Default"})
     */
    private $message = "";
    /**
     * @ORM\Column(name="created_at", type="datetime")
     *
     */
    private $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
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
        return $this->createdBy;
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
        return $this->createdAt;
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
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @param User $created_by
     */
    public function setCreatedBy(User $createdBy)
    {
        $this->createdBy = $createdBy;
    }
}
