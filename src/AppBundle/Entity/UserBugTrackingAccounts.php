<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Torrent
 *
 * @ORM\Table(name="user_bug_tracking_accounts")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserBugTrackingAccountsRepository")
 */
class UserBugTrackingAccounts
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
     * ORM\ManyToOne(targetEntity="AppBundle\Entity\BugTrackingSystems", inversedBy="users")
     * ORM\JoinColumn(name="service_id", referencedColumnName="id")
     */
    //private $serviceData;

    /**
     * @var integer
     * @ORM\Column(name="service_id", type="integer")
     */
    private $serviceId;


    /**
     * @var integer
     * @ORM\Column(name="user_id", type="integer")
     */
    private $userId;


    /**
     * @var string
     * @ORM\Column(name="cookie", type="string")
     */
    private $cookie;

    /**
     * @return int
     */
    public function getServiceId()
    {
        return $this->serviceId;
    }

    /**
     * @param int $serviceId
     */
    public function setServiceId($serviceId)
    {
        $this->serviceId = $serviceId;
    }

    /**
     * @return mixed
     */
    /*public function getServiceData()
    {
        return $this->serviceData;
    }*/

    /**
     * @param mixed $serviceData
     */
    /*public function setServiceData($serviceData)
    {
        $this->serviceData = $serviceData;
    }*/



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
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param $userId
     * @return $this
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }


    /**
     * @return string
     */
    public function getCookie()
    {
        return $this->cookie;
    }

    /**
     * @param $cookie
     * @return $this
     */
    public function setCookie($cookie)
    {
        $this->cookie = $cookie;

        return $this;
    }

}
