<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use KofeinStyle\Helper\Dumper;
use Lexik\Bundle\JWTAuthenticationBundle\Security\User\JWTUserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks
 */
class User implements JWTUserInterface, \Serializable
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=25, unique=true)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=64)
     */
    private $password = '';

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=60, unique=true)
     */
    private $email;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="role", type="string", length=25, unique=false)
	 */
    private $role;

    /**
     * @var string
     *
     * @ORM\Column(name="token", type="string", length=6000, unique=false, nullable = true)
     */
    private $token;

    /**
     * @var string
     *
     * @ORM\Column(name="google_access_token", type="string", length=5000, unique=false, nullable = true)
     */
    private $google_access_token;


    /**
     * @var string
     *
     * @ORM\Column(name="google_id_token", type="string", length=3000, unique=false, nullable = true)
     */

    private $google_id_token;
    /**
     * @var string
     *
     * @ORM\Column(name="folder_id", type="string", length=100, unique=true, nullable = true)
     */
    private $folder_id;

      /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return User
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return bool
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    public function getSalt()
    {
        return null;
    }

    public function getRoles()
    {
        return [$this->role];
    }

    /**
     * @param string $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }


    public function eraseCredentials()
    {
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @return string
     */
    public function getGoogleAccessToken()
    {
        return $this->google_access_token;
    }

    /**
     * @return string
     */
    public function getGoogleAccessTokenDecoded()
    {
        return json_decode($this->google_access_token, true);
    }


    /**
     * @param string $google_access_token
     */
    public function setGoogleAccessToken($google_access_token)
    {
        $this->google_access_token = $google_access_token;
    }

    /**
     * @return string
     */
    public function getGoogleIdToken()
    {
        return $this->google_id_token;
    }

    /**
     * @param string $google_id_token
     */
    public function setGoogleIdToken($google_id_token)
    {
        $this->google_id_token = $google_id_token;
    }

    public function __construct()
    {
        $this->isActive = true;
    }

    public static function createFromPayload($username, array $payload)
    {

    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize([$this->id, $this->username, $this->password]);
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list ($this->id, $this->username, $this->password,) = unserialize($serialized);
    }

    /**
     * @param $folder_id
     */
    public function setFolderId($folder_id)
    {
        $this->folder_id = $folder_id;
    }

    /**
     * @return string
     */
    public function getFolderId()
    {
        return $this->folder_id;
    }
}

