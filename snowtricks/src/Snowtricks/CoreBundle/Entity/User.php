<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 01/04/2017
 * Time: 17:27
 */
namespace Snowtricks\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 *
 * @ORM\Table(name="snow_user")
 * @ORM\Entity(repositoryClass="Snowtricks\CoreBundle\Repository\UserRepository")
 */
class User implements UserInterface {
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
    /**
     * @ORM\Column(name="surname", type="string", nullable=false)
     *
     */
    private $surname = "";
    /**
     * @ORM\Column(name="mail", type="string", nullable=false, unique=true)
     *
     */
    private $mail = "";
    /**
     * @ORM\Column(name="picture", type="string", nullable=true)
     *
     */
    private $picture = "";
    /**
     * @ORM\Column(name="roles", type="array", nullable=false)
     *
     */
    private $roles = [];
    /**
     * @ORM\Column(name="password", type="string", nullable=false)
     *
     */
    private $password;
    /**
     * @ORM\Column(name="salt", type="string", nullable=false)
     *
     */
    private $salt = "";

    /**
     * @ORM\Column(name="username", type="string", nullable=false, unique=true)
     *
     */
    private $username;

    /**
     * A non-persisted field that's used to create the encoded password.
     *
     * @var string
     */
    private $plainPassword;

   public function __construct($mail = NULL)
    {
        if ($mail !== NULL){
            $this->username = $mail;
        }
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @return string
     */
    public function getMail()
    {

        return $this->mail;
    }

    /**
     * @return string
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
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
     * @param string $surname
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
    }

    /**
     * @param string $mail
     */
    public function setMail($mail)
    {
        $this->mail = $mail;
        $this->username = $mail;
    }

    /**
     * @param string $picture
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;
    }

    /**
     * @param array $roles
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @param string $salt
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    /**
     * @param string $plainPassword
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
        $this->password = null;
    }

    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }
}
