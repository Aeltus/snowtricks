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
use Symfony\Component\Form\Exception\InvalidArgumentException;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 *
 * @ORM\Table(name="snow_picture")
 * @ORM\Entity(repositoryClass="Snowtricks\CoreBundle\Repository\PictureRepository")
 * @ORM\HasLifecycleCallbacks()
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
     */
    private $createdAt;
    /**
     * @ORM\ManyToOne(targetEntity="Snowtricks\CoreBundle\Entity\User")
     * @ORM\JoinColumn(nullable=true)
     *
     */
    private $createdBy = NULL;

    /**
     * @ORM\ManyToOne(targetEntity="Snowtricks\CoreBundle\Entity\Trick", inversedBy="pictures")
     *
     */
    private $trick;

    private $file;

    private $cropData = NULL;

    private $cropedPicture;

    private $originalWidth;

    private $originalHeight;

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
        return $this->createdAt;
    }

    /**
     * @return \User
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
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
    public function getTrick()
    {
        return $this->trick;
    }

    /**
     * @return mixed
     */
    public function getCropData()
    {
        return $this->cropData;
    }

    /**
     * @return mixed
     */
    public function getFullSize()
    {
        return $this->getUploadDir().'/fullSize/'.$this->address;
    }

    /**
     * @return mixed
     */
    public function getThumbnailSize()
    {
        return $this->getUploadDir().'/thumbnail/'.$this->address;
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
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @param \User $created_by
     */
    public function setCreatedBy(User $createdBy)
    {
        $this->createdBy = $createdBy;
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
     * @param mixed $Trick
     */
    public function setTrick($Trick)
    {
        $this->trick = $Trick;
    }

    /**
     * @param mixed $cropData
     */
    public function setCropData($cropData)
    {
        $this->cropData = $cropData;
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
        if ($this->file->getMimeType() != 'image/jpg' && $this->file->getMimeType() != 'image/jpeg'){
            throw new InvalidArgumentException('Le fichier doit être de type image jpg.');
        }

        // we get the orgiginal name of the file
        $name = $this->file->getClientOriginalName();
        $ext = substr(strrchr($name,'.'),1);
        $newName = uniqid(rand(), true).'.'.$ext;
        $this->address = $newName;

        $this->file->move($this->getUploadRootDir().'/tmp', $newName);

        // We clean file attribute (witch is now useless)
        $this->file = NULL;

    }

    public function getUploadDir()
    {
        return 'uploads';
    }

    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    /**
     * @ORM\PostRemove
     */
    public function removePicture()
    {
        unlink($this->getUploadRootDir().'/../'.$this->getFullSize());
        unlink($this->getUploadRootDir().'/../'.$this->getThumbnailSize());
    }

    public function crop(){
        if ($originalPictureSize = getimagesize($this->getUploadRootDir().'/tmp/'.$this->address)){
            $cropData = $this->getCropData();

            $this->originalWidth = $originalPictureSize[0];
            $this->originalHeight = $originalPictureSize[1];

            if ($this->originalWidth > 1170){
                $newHeight = $this->originalHeight / $this->originalWidth * 1170;
                $this->createThumbnail(1170, $newHeight, 'tmp', 'tmp');
                $this->originalHeight = $newHeight;
                $this->originalWidth = 1170;
            }

            $finalWidth = $this->originalWidth * ($cropData->getCropSizeWidth()/$cropData->getCropHolderWidth());
            $finalHeight = $this->originalHeight * ($cropData->getCropSizeHeight()/$cropData->getCropHolderHeight());

            $sourcePointY = $this->originalHeight * $cropData->getCropPositionTop() / ($cropData->getCropSizeHeight()+$cropData->getCropPositionTop());
            $sourcePointX = $this->originalWidth * $cropData->getCropPositionLeft() / ($cropData->getCropSizeWidth()+$cropData->getCropPositionLeft());

            $originalPicture = imagecreatefromjpeg($this->getUploadRootDir().'/tmp/'.$this->address);

            $this->cropedPicture = imagecreatetruecolor($finalWidth, $finalHeight);

            imagecopyresampled($this->cropedPicture, $originalPicture,
                0, 0,
                $sourcePointX, $sourcePointY,
                $finalWidth, $finalHeight,
                $finalWidth, $finalHeight
            );

            imagejpeg($this->cropedPicture, $this->getFullSize(), 100);
            imagedestroy($this->cropedPicture);
            imagedestroy($originalPicture);
            unlink($this->getUploadRootDir().'/tmp/'.$this->address);
            $this->cropedPicture = NULL;
        }

        return $this;
    }

    public function createThumbnail($finalWidth, $finalHeight, $destination = 'thumbnail', $origin = 'fullSize'){
        if ($originalPictureSize = getimagesize($this->getUploadRootDir().'/../'.$this->getUploadDir().'/'.$origin.'/'.$this->address)){

            $originalPicture = imagecreatefromjpeg($this->getUploadRootDir().'/../'.$this->getUploadDir().'/'.$origin.'/'.$this->address);
            $originalPictureSize = getimagesize($this->getUploadRootDir().'/../'.$this->getUploadDir().'/'.$origin.'/'.$this->address);

            $this->cropedPicture = imagecreatetruecolor($finalWidth, $finalHeight);
            imagecopyresampled($this->cropedPicture, $originalPicture,
                0, 0,
                0, 0,
                $finalWidth, $finalHeight,
                $originalPictureSize[0], $originalPictureSize[1]);

            imagejpeg($this->cropedPicture, $this->getUploadRootDir().'/../'.$this->getUploadDir().'/'.$destination.'/'.$this->address, 100);
            imagedestroy($this->cropedPicture);
            imagedestroy($originalPicture);
            $this->cropedPicture = NULL;
        }

        return $this;
    }

}
