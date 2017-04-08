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
     * @Assert\Length(min=3, minMessage="Votre nom doit faire au moins {{ limit }} caractères.")
     * @Assert\Length(max=255, maxMessage="Votre nom doit faire au maximum {{ limit }} caractères.")
     * @Assert\NotBlank(message="Vous devez inscrire votre nom.")
     * @Assert\Type("string")
     */
    private $name = "";
    /**
     * @ORM\Column(name="surname", type="string", nullable=false)
     *
     * @Assert\Length(min=3, minMessage="Votre prenom doit faire au moins {{ limit }} caractères.")
     * @Assert\Length(max=255, maxMessage="Votre prenom doit faire au maximum {{ limit }} caractères.")
     * @Assert\NotBlank(message="Vous devez inscrire votre prenom.")
     * @Assert\Type("string")
     */
    private $surname = "";
    /**
     * @ORM\Column(name="mail", type="string", nullable=false, unique=true)
     *
     * @Assert\Length(min=3, minMessage="Votre email doit faire au moins {{ limit }} caractères.", groups={"Default", "Recovery"})
     * @Assert\Length(max=255, maxMessage="Votre email doit faire au maximum {{ limit }} caractères.", groups={"Default", "Recovery"})
     * @Assert\NotBlank(message="Vous devez inscrire votre email.", groups={"Default", "Recovery"})
     * @Assert\Email(groups={"Default", "Recovery"})
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
     * @ORM\Column(name="username", type="string", nullable=false, unique=true)
     *
     */
    private $username;

    /**
     *
     * @Assert\Type("string")
     * @Assert\NotBlank(message="Un mot de passe est obligatoire.", groups={"Registration"})
     * @Assert\Length(min=6, minMessage="Votre mot de passe doit faire au minimum {{ limit }} caractères.", groups={"Registration"})
     * @Assert\Length(max=20, maxMessage="Votre mot de passe doit faire au maximum {{ limit }} caractères.", groups={"Registration"})
     */
    private $plainPassword;

    /**
     * To get the image file and treat her
     *
     * @Assert\Image(maxSize="1M", maxSizeMessage="Fichier trop volumineux, 1Mo maximum.", mimeTypesMessage="Type de fichier non supporté, fichiers images seulement.")
     */
    private $file;

    /**
     * @ORM\Column(name="identification_token", type="string", nullable=true, unique=true)
     *
     */
    private $identification_token = NULL;

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
    public function getFile()
    {
        return $this->file;
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
    public function getIdentificationToken()
    {
        return $this->identification_token;
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

    /**
     * @param mixed $file
     */
    public function setFile($file)
    {
        $this->file = $file;
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
     * @param mixed $identification_token
     */
    public function setIdentificationToken($identification_token)
    {
        $this->identification_token = $identification_token;
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

    public function upload()
    {
        // If there is no file, we do nothing
        if (null === $this->file) {
            return;
        }

        // we get the orgiginal name of the file
        $name = $this->file->getClientOriginalName();
        $ext = substr(strrchr($name,'.'),1);
        $newName = time().'.'.$ext;

        // We move him in the dir of our choice
        $this->file->move($this->getUploadRootDir(), $newName);

        // We save url in picture attribute and clean file attribute (witch is now useless)
        $this->picture = $newName;
        $this->file = NULL;

    }


    public function getUploadDir()
    {
        return 'uploads_users';
    }

    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }
}
