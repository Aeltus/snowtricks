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
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 *
 * @ORM\Table(name="snow_picture")
 * @ORM\Entity(repositoryClass="Snowtricks\CoreBundle\Repository\PictureRepository")
 *
 * @UniqueEntity(fields={"address"}, message="Erreur interne, cette image existe déjà, merci de re-essayer plus tard.")
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
     * @Assert\Type("string", groups={"Default"})
     */
    private $created_at;
    /**
     * @ORM\ManyToOne(targetEntity="Snowtricks\CoreBundle\Entity\User", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     *
     */
    private $created_by = NULL;

    /**
     * @ORM\ManyToOne(targetEntity="Snowtricks\CoreBundle\Entity\Trick", inversedBy="pictures", cascade={"persist"})
     *
     */
    private $id_trick;

    /**
     * @Assert\Image(maxSize="1M", maxSizeMessage="Fichier trop volumineux, 1Mo maximum.", mimeTypesMessage="Type de fichier non supporté, fichiers images seulement.")
     */
    private $file;

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

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
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

    /**
     * @param mixed $file
     */
    public function setFile(UploadedFile $file)
    {
        $this->file = $file;
        $this->upload();

    }

    /**
     * @param mixed $idTrick
     */
    public function setIdTrick($idTrick)
    {
        $this->id_trick = $idTrick;
    }
    /**=================================================================================================================
    =                                                                                                                 =
    =                                           Others                                                                =
    =                                                                                                                 =
    ================================================================================================================**/


    private function upload()
    {
        // If there is no file, we do nothing
        if (null === $this->file) {
            return;
        }

        // we get the orgiginal name of the file
        $name = $this->file->getClientOriginalName();
        $ext = substr(strrchr($name,'.'),1);
        $newName = uniqid(rand(), true).'.'.$ext;

        // We move him in the dir of our choice
        $this->file->move($this->getUploadRootDir(), $newName);

        // We save url in address attribute and clean file attribute (witch is now useless)
        $this->address = '/'.$this->getUploadDir().'/'.$newName;
        $this->file = NULL;

    }


    public function getUploadDir()
    {
        return 'uploads_tricks';
    }

    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

}
