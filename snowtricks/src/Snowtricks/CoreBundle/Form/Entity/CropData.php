<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 29/04/2017
 * Time: 11:16
 */
namespace Snowtricks\CoreBundle\Form\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class CropData {

    /**
     * @Assert\Type(type = "integer", message="Ce champ ne dois pas être modifié.")
     */
    private $cropSizeHeight = 0;

    /**
     * @Assert\Type(type = "integer", message="Ce champ ne dois pas être modifié.")
     */
    private $cropSizeWidth = 0;

    /**
     * @Assert\Type(type = "integer", message="Ce champ ne dois pas être modifié.")
     */
    private $cropPositionTop = 0;

    /**
     * @Assert\Type(type = "integer", message="Ce champ ne dois pas être modifié.")
     */
    private $cropPositionLeft = 0;

    /**
     * @Assert\Type(type = "integer", message="Ce champ ne dois pas être modifié.")
     */
    private $cropHolderWidth = 0;

    /**
     * @Assert\Type(type = "integer", message="Ce champ ne dois pas être modifié.")
     */
    private $cropHolderHeight = 0;

    /**=================================================================================================================
    =                                                                                                                 =
    =                                          Getters                                                                =
    =                                                                                                                 =
    ================================================================================================================**/

    /**
     * @return int
     */
    public function getCropSizeHeight()
    {
        return $this->cropSizeHeight;
    }

    /**
     * @return int
     */
    public function getCropSizeWidth()
    {
        return $this->cropSizeWidth;
    }

    /**
     * @return int
     */
    public function getCropPositionTop()
    {
        return $this->cropPositionTop;
    }

    /**
     * @return int
     */
    public function getCropPositionLeft()
    {
        return $this->cropPositionLeft;
    }

    /**
     * @return mixed
     */
    public function getCropHolderHeight()
    {
        return $this->cropHolderHeight;
    }

    /**
     * @return mixed
     */
    public function getCropHolderWidth()
    {
        return $this->cropHolderWidth;
    }
    /**=================================================================================================================
    =                                                                                                                 =
    =                                          Setters                                                                =
    =                                                                                                                 =
    ================================================================================================================**/

    /**
     * @param int $cropSizeHeight
     */
    public function setCropSizeHeight($cropSizeHeight)
    {
        $this->cropSizeHeight = $cropSizeHeight;
    }

    /**
     * @param int $cropSizeWidht
     */
    public function setCropSizeWidth($cropSizeWidht)
    {
        $this->cropSizeWidth = $cropSizeWidht;
    }

    /**
     * @param int $cropPositionTop
     */
    public function setCropPositionTop($cropPositionTop)
    {
        $this->cropPositionTop = $cropPositionTop;
    }

    /**
     * @param int $cropPositionLeft
     */
    public function setCropPositionLeft($cropPositionLeft)
    {
        $this->cropPositionLeft = $cropPositionLeft;
    }

    /**
     * @param mixed $copHolderHeight
     */
    public function setCropHolderHeight($cropHolderHeight)
    {
        $this->cropHolderHeight = $cropHolderHeight;
    }

    /**
     * @param mixed $cropHolderWidth
     */
    public function setCropHolderWidth($cropHolderWidth)
    {
        $this->cropHolderWidth = $cropHolderWidth;
    }
}


