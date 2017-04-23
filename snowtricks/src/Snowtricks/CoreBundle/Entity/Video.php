<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 01/04/2017
 * Time: 18:26
 */
namespace Snowtricks\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Snowtricks\CoreBundle\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;

/**
 *
 * @ORM\Table(name="snow_video")
 * @ORM\Entity(repositoryClass="Snowtricks\CoreBundle\Repository\VideoRepository")
 */
class Video {
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
     * @Assert\Type("string", groups={"Default"})
     */
    private $created_at;
    /**
     * @ORM\ManyToOne(targetEntity="Snowtricks\CoreBundle\Entity\User", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $created_by = NULL;

    /**
     * @ORM\ManyToOne(targetEntity="Snowtricks\CoreBundle\Entity\Trick", inversedBy="videos", cascade={"persist"})
     *
     */
    private $id_trick;

    public function __construct()
    {

        $this->created_at = new \DateTime();
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
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @return mixed
     */
    public function getCreatedBy()
    {
        return $this->created_by;
    }

    /**
     * @return mixed
     */
    public function getIdTrick()
    {
        return $this->id_trick;
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
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @param mixed $created_at
     */
    public function setCreatedAt(\DateTime $created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * @param mixed $created_by
     */
    public function setCreatedBy(User $created_by)
    {
        $this->created_by = $created_by;
    }

    /**
     * @param mixed $idTrick
     */
    public function setIdTrick($idTrick)
    {
        $this->id_trick = $idTrick;
    }
}
