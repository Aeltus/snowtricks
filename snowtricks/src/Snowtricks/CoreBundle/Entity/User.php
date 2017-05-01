<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 01/04/2017
 * Time: 17:27
 */
namespace Snowtricks\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 *
 * @ORM\Table(name="snow_user")
 * @ORM\Entity(repositoryClass="Snowtricks\CoreBundle\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks()
 *
 * @UniqueEntity(fields={"mail"}, message="Votre email est déjà enregitré dans notre base, si vous avez perdu votre mot de passe, allez sur la page de connection, et cliquez sur : mot de passe perdu")
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
     * @Assert\Length(min=3, minMessage="Votre nom doit faire au moins {{ limit }} caractères.", groups={"Default", "UpdateAccount"})
     * @Assert\Length(max=255, maxMessage="Votre nom doit faire au maximum {{ limit }} caractères.", groups={"Default", "UpdateAccount"})
     * @Assert\NotBlank(message="Vous devez inscrire votre nom.", groups={"Default", "UpdateAccount"})
     * @Assert\Type("string", groups={"Default", "UpdateAccount"})
     */
    private $name = "";
    /**
     * @ORM\Column(name="surname", type="string", nullable=false)
     *
     * @Assert\Length(min=3, minMessage="Votre prenom doit faire au moins {{ limit }} caractères.", groups={"Default", "UpdateAccount"})
     * @Assert\Length(max=255, maxMessage="Votre prenom doit faire au maximum {{ limit }} caractères.", groups={"Default", "UpdateAccount"})
     * @Assert\NotBlank(message="Vous devez inscrire votre prenom.", groups={"Default", "UpdateAccount"})
     * @Assert\Type("string", groups={"Default", "UpdateAccount"})
     */
    private $surname = "";
    /**
     * @ORM\Column(name="mail", type="string", nullable=true, unique=true)
     *
     * @Assert\Length(min=3, minMessage="Votre email doit faire au moins {{ limit }} caractères.", groups={"Default", "Recovery", "UpdateAccount"})
     * @Assert\Length(max=255, maxMessage="Votre email doit faire au maximum {{ limit }} caractères.", groups={"Default", "Recovery", "UpdateAccount"})
     * @Assert\NotBlank(message="Vous devez inscrire votre email.", groups={"Default", "Recovery", "UpdateAccount"})
     * @Assert\Email(message="Ceci n'est pas un email valide.", groups={"Default", "Recovery", "UpdateAccount"})
     */
    private $mail = "";
    /**
     * @ORM\OneToOne(targetEntity="Snowtricks\CoreBundle\Entity\Picture", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     *
     * @Assert\Valid
     *
     */
    private $picture;
    /**
     * @ORM\Column(name="roles", type="array", nullable=false)
     *
     * @Assert\Type("array")
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
     * @ORM\Column(name="username", type="string", nullable=true)
     *
     */
    private $username;

    /**
     *
     * @Assert\Type("string", groups={"Default", "UpdateAccount"})
     * @Assert\NotBlank(message="Un mot de passe est obligatoire.", groups={"Registration"})
     * @Assert\Length(min=6, minMessage="Votre mot de passe doit faire au minimum {{ limit }} caractères.", groups={"Registration", "UpdateAccount"})
     * @Assert\Length(max=20, maxMessage="Votre mot de passe doit faire au maximum {{ limit }} caractères.", groups={"Registration", "UpdateAccount"})
     */
    private $plainPassword;

    /**
     * @ORM\Column(name="checking_token", type="string", nullable=true)
     *
     */
    private $checking_token = NULL;

    /**
     * @ORM\Column(name="checked", type="boolean", nullable=false)
     *
     */
    private $checked = FALSE;

    private $lastPicture = NULL;

   public function __construct($mail = NULL)
    {
        if ($mail !== NULL) {
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

    /**
     * @return mixed
     */
    public function getCheckingToken()
    {
        return $this->checking_token;
    }

    /**
     * @return mixed
     */
    public function isChecked()
    {
        return $this->checked;
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
    public function setPicture(Picture $picture)
    {
        if ($this->picture != ""){
            $this->lastPicture = $this->picture;
        }
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

    /**
     * @param mixed $checked
     */
    public function setChecked($checked)
    {
        $this->checked = $checked;
    }

    /**
     * @param mixed $checking_token
     */
    public function setCheckingToken($checking_token)
    {
        $this->checking_token = $checking_token;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**=================================================================================================================
    =                                                                                                                 =
    =                                       Others traitments                                                         =
    =                                                                                                                 =
    ================================================================================================================**/

    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }

    public function removePicture(){
        $this->picture = NULL;
    }

}
