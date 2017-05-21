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
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 *
 * @ORM\Table(name="snow_trick")
 * @ORM\Entity(repositoryClass="Snowtricks\CoreBundle\Repository\TrickRepository")
 *
 * @UniqueEntity(fields={"title"}, message="Il exite déjà un article ayant ce titre. Pour garder une certaine clarté, merci de choisir un titre unique.")
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
     * @Assert\Length(min=3, minMessage="Le titre doit faire au moins {{ limit }} caractères.", groups={"Default"})
     * @Assert\Length(max=255, maxMessage="Le titre doit faire au maximum {{ limit }} caractères.", groups={"Default"})
     * @Assert\NotBlank(message="Le titre est obligatoire", groups={"Default"})
     * @Assert\Type("string", groups={"Default"})
     *
     */
    private $title = "";
    /**
     * @ORM\Column(name="description", type="string", nullable=false)
     *
     * @Assert\Length(min=3, minMessage="La description doit faire au moins {{ limit }} caractères.", groups={"Default"})
     * @Assert\Length(max=255, maxMessage="La description doit faire au maximum {{ limit }} caractères.", groups={"Default"})
     * @Assert\NotBlank(message="Une description est obligatoire.", groups={"Default"})
     * @Assert\Type("string", groups={"Default"})
     *
     */
    private $description = "";
    /**
     * @ORM\ManyToOne(targetEntity="Snowtricks\CoreBundle\Entity\Group")
     *
     * @Assert\Type(
     *     type="object",
     *     message="Ce champ est sencé recevoir un groupe."
     * )
     */
    private $group;

    /**
     * @ORM\OneToMany(targetEntity="Snowtricks\CoreBundle\Entity\Picture", mappedBy="trick", orphanRemoval=true)
     *
     */
    private $pictures = [];

    /**
     * @ORM\OneToMany(targetEntity="Snowtricks\CoreBundle\Entity\Video", mappedBy="trick", orphanRemoval=true)
     *
     */
    private $videos = [];

    /**
     * @ORM\Column(name="created_at", type="datetime")
     *
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="Snowtricks\CoreBundle\Entity\User", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $createdBy;

    /**
     * @Assert\Type("array")
     */
    private $uploadPictures = [];

    public function __construct()
    {
        $this->pictures = new ArrayCollection();
        $this->videos = new ArrayCollection();
        $this->createdAt = new \DateTime();
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
        return $this->createdAt;
    }

    /**
     * @return mixed
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * @return mixed
     */
    public function getUploadPictures()
    {
        return $this->uploadPictures;
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
    public function setCreatedBy(User $createdBy)
    {
        $this->createdBy = $createdBy;
    }

    /**
     * @param mixed $uploadPictures
     */
    public function setUploadPictures($files)
    {

        // If there is no file, we do nothing
        foreach ($files as $file){
            if ($file !== NULL){
                $this->addPicture($file);
            }
        }
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
    public function addVideo(Video $video = NULL){
        if ($video !== NULL){
            $this->videos[] = $video;
        }
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
