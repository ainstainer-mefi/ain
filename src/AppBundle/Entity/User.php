<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
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
    private $password;

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
     * @ORM\Column(name="google_access_token", type="string", length=255, unique=false, nullable = true)
     */
    private $google_access_token;

    /**
     * @var string
     *
     * @ORM\Column(name="google_id_token", type="string", length=3000, unique=false, nullable = true)
     */
    private $google_id_token;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="google_access_token_expires_in", type="datetime", nullable = true)
     */
    private $google_access_token_expires_in;

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

    /**
     * @return \DateTime
     */
    public function getGoogleAccessTokenExpiresIn()
    {
        return $this->google_access_token_expires_in;
    }

    /**
     * @param \int $google_access_token_expires_in
     */
    public function setGoogleAccessTokenExpiresIn($google_access_token_expires_in)
    {
        $this->google_access_token_expires_in = new \DateTime(date('Y-m-d H:i:s', $google_access_token_expires_in));
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
}

