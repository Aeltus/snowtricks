<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 01/04/2017
 * Time: 18:17
 */
namespace Snowtricks\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 *
 * @ORM\Table(name="snow_group")
 * @ORM\Entity(repositoryClass="Snowtricks\CoreBundle\Repository\GroupRepository")
 *
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
     * @ORM\Column(name="name", type="string", nullable=false, unique=true)
     *
     * @Assert\Length(min=3, minMessage="Le nom du groupe doit faire au moins {{ limit }} caractères.", groups={"Default", "UpdateAccount"})
     * @Assert\Length(max=255, maxMessage="Le nom du groupe doit faire au maximum {{ limit }} caractères.", groups={"Default", "UpdateAccount"})
     * @Assert\NotBlank(message="Vous devez donner un nom au nouveau groupe.")
     * @Assert\Type("string")
     */
    private $name = "";


    private $updateForm = NULL;


    public function __construct($name = NULL)
    {
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

    /**
     * @return null | string
     */
    public function getUpdateForm()
    {
        return $this->updateForm;
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

    /**
     * @param $updateForm
     */
    public function setUpdateForm($updateForm)
    {
        $this->updateForm = $updateForm;
    }

}
