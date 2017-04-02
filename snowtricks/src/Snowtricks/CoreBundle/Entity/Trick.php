<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 01/04/2017
 * Time: 18:35
 */
namespace Snowtricks\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Snowtricks\CoreBundle\Entity\Group;
use Snowtricks\CoreBundle\Entity\Picture;
use Snowtricks\CoreBundle\Entity\User;
use Snowtricks\CoreBundle\Entity\Video;

/**
 *
 * @ORM\Table(name="snow_trick")
 * @ORM\Entity(repositoryClass="Snowtricks\CoreBundle\Repository\TrickRepository")
 */
class Trick {
    /**
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     */
    private $id = 0;
    /**
     * @ORM\Column(name="title", type="string", nullable=false)
     *
     */
    private $title = "";
    /**
     * @ORM\Column(name="description", type="string", nullable=false)
     *
     */
    private $description = "";
    /**
     * @ORM\ManyToOne(targetEntity="Snowtricks\CoreBundle\Entity\Group", cascade={"persist"})
     *
     */
    private $group;
    /**
     * @ORM\ManyToMany(targetEntity="Snowtricks\CoreBundle\Entity\Picture", cascade={"persist"})
     * @ORM\JoinTable(name="snow_trick_picture")
     *
     */
    private $pictures = [];
    /**
     * @ORM\ManyToMany(targetEntity="Snowtricks\CoreBundle\Entity\Video", cascade={"persist"})
     * @ORM\JoinTable(name="snow_trick_video")
     *
     */
    private $videos = [];
    /**
     * @ORM\Column(name="created_at", type="datetime")
     *
     */
    private $created_at;
    /**
     * @ORM\ManyToOne(targetEntity="Snowtricks\CoreBundle\Entity\User", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $created_by;

    public function __construct($id = NULL, $title, $description,Group $group,\DateTime $created_at,User $created_by)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->group = $group;
        $this->pictures = new ArrayCollection();
        $this->videos = new ArrayCollection();
        $this->created_at = $created_at;
        $this->created_by = $created_by;

    }
    /**=================================================================================================================
    =                                                                                                                 =
    =                                          Getters                                                                =
    =                                                                                                                 =
    ================================================================================================================**/
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @return mixed
     */
    public function getPictures()
    {
        return $this->pictures;
    }

    /**
     * @return mixed
     */
    public function getVideos()
    {
        return $this->videos;
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
    /**=================================================================================================================
    =                                                                                                                 =
    =                                          Setters                                                                =
    =                                                                                                                 =
    ================================================================================================================**/
    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @param mixed $group
     */
    public function setGroup(Group $group)
    {
        $this->group = $group;
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
    /**=================================================================================================================
    =                                                                                                                 =
    =                                    Array Collection Add and Remove                                              =
    =                                                                                                                 =
    ================================================================================================================**/
    /**
     * @param Picture $picture
     */
    public function addPicture(Picture $picture){
        $this->pictures[] = $picture;
    }

    /**
     * @param Video $video
     */
    public function addVideo(Video $video){
        $this->videos[] = $video;
    }

    /**
     * @param Picture $picture
     */
    public function removePicture (Picture $picture){
        $this->pictures->removeElement($picture);
    }

    /**
     * @param Video $video
     */
    public function removeVideo (Video $video){
        $this->videos->removeElement($video);
    }
}
