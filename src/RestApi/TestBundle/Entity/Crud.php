<?php

namespace RestApi\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Crud
 *
 * @ORM\Table(name="crud")
 * @ORM\Entity(repositoryClass="RestApi\TestBundle\Repository\CrudRepository")
 */
class Crud
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
     * @ORM\Column(name="firstName", type="string", length=255)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=255)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="logoFile", type="string", length=255)
     */
    private $logoFile;

    /**
     * @var string
     *
     * @ORM\Column(name="userRole", type="string", length=255)
     */
    private $userRole;


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
     * Set firstName
     *
     * @param string $firstName
     *
     * @return Crud
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return Crud
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set logoFile
     *
     * @param string $logoFile
     *
     * @return Crud
     */
    public function setLogoFile($logoFile)
    {
        $this->logoFile = $logoFile;

        return $this;
    }

    /**
     * Get logoFile
     *
     * @return string
     */
    public function getLogoFile()
    {
        return $this->logoFile;
    }

    /**
     * Set userRole
     *
     * @param string $userRole
     *
     * @return Crud
     */
    public function setUserRole($userRole)
    {
        $this->userRole = $userRole;

        return $this;
    }

    /**
     * Get userRole
     *
     * @return string
     */
    public function getUserRole()
    {
        return $this->userRole;
    }
}

