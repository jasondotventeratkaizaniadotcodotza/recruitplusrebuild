<?php

namespace RM\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Table(name="users",uniqueConstraints={@ORM\UniqueConstraint(name="unique_email", columns={"email"})})
 * @ORM\Entity(repositoryClass="RM\Entity\Repository\UserRepository")
 * @author Csabi
 */
class User
{

    const GUEST = 'guest';
    const RECRUITER = 'recruiter';
    const SEEKER = 'seeker';
    const USER_STATUS_PENDING_ID = 1;
    const USER_STATUS_ENABLED_ID = 2;
    const USER_STATUS_DISABLED_ID = 3;
    const USER_STATUS_BLACKLISTED_ID = 4;
    const USER_SYSTEM_NOTIFICATIONS_NOT_SPECIFIED = -1;
    const USER_SYSTEM_NOTIFICATIONS_ON = 1;
    const USER_SYSTEM_NOTIFICATIONS_OFF = 2;

    /**
     * @var integer $id 
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /*
     * @ORM\OneToMany(targetEntity="JobListing",mappedBy="userId", cascade={"all"})
     */
    private $jobListings;
    
    /*
     * @ORM\OneToMany(targetEntity="ApplicationRatings",mappedBy="userId", cascade={"all"})
     */
    private $applicationRatings;

    /**
     *
     * @var string $firstName 
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $firstName;

    /**
     *
     * @var string $lastName 
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $lastName;

    /**
     * @var Roles
     * @ORM\ManyToOne(targetEntity="Roles", cascade={"all"}, fetch="EAGER")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="roleId", referencedColumnName="id",  nullable=false)
     * })
     */
    private $role;

    /**
     * @var string $email
     * @ORM\Column(type="string", nullable=false)
     */
    private $email;

    /**
     * @var string $password
     * @ORM\Column(type="string", nullable=true)
     */
    private $password;
    
    /**
     * @var string $password
     * @ORM\Column(type="string", nullable=false)
     */
    private $salt;

    /**
     *
     * @var integer $userStatus 
     * @ORM\Column(type="integer", nullable=false)
     */
    private $userStatus;
    
    /**
     * @var string $phoneNumber
     * @ORM\Column(type="string", nullable=true)
     */
    private $phoneNumber;
    
    /**
     * @var Geolocation
     * @ORM\ManyToOne(targetEntity="Geolocation", fetch="EAGER")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="locationId", referencedColumnName="id")
     * })
     */
    private $locationId;
    
    /**
     *
     * @var integer $systemNotifications 
     * @ORM\Column(type="integer", nullable=false)
     */
    private $systemNotifications;

    /**
     *
     * @var type $createdTime
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $createdTime;

    /**
     *
     * @var type $lastLoginTime
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $lastLoginTime;
    
    /**
     *
     * @var type $lastIpAddress
     * @ORM\Column(type="string", nullable=false)
     */
    private $lastIpAddress;
    
    /**
     *
     * @var type $lastUserAgent
     * @ORM\Column(type="string", nullable=false)
     */
    private $lastUserAgent;
    
    /**
     *
     * @var type $clientDeviceId
     * @ORM\Column(type="integer", nullable=true)
     */
    private $clientDeviceId;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getCreatedTime()
    {
        return $this->createdTime;
    }

    public function setCreatedTime($createdTime)
    {
        $this->createdTime = $createdTime;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    public function getFullName()
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role)
    {
        $this->role = $role;
    }

    public function isGuest()
    {
        return ($this->role->getRole() == self::GUEST) ? true : false; 
    }

    public function isRecruiter()
    {
        return ($this->role->getRole() == self::RECRUITER) ? true : false; 
    }

    public function isSeeker()
    {
        return ($this->role->getRole() == self::SEEKER) ? true : false; 
    }
    
    public function getUserStatus()
    {
        return $this->userStatus;
    }

    public function setUserStatus($userStatus)
    {
        $this->userStatus = $userStatus;
    }

    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

    public function getLocationId()
    {
        return $this->locationId;
    }

    public function setLocationId($locationId)
    {
        $this->locationId = $locationId;
    }

    public function getSystemNotifications()
    {
        return $this->systemNotifications;
    }

    public function setSystemNotifications($systemNotifications)
    {
        $this->systemNotifications = $systemNotifications;
    }

    public function getLastLoginTime()
    {
        return $this->lastLoginTime;
    }

    public function setLastLoginTime($lastLoginTime)
    {
        $this->lastLoginTime = $lastLoginTime;
    }

    public function getLastIpAddress()
    {
        return $this->lastIpAddress;
    }

    public function setLastIpAddress($lastIpAddress)
    {
        $this->lastIpAddress = $lastIpAddress;
    }

    public function getLastUserAgent()
    {
        return $this->lastUserAgent;
    }

    public function setLastUserAgent($lastUserAgent)
    {
        $this->lastUserAgent = $lastUserAgent;
    }

    public function getClientDeviceId()
    {
        return $this->clientDeviceId;
    }

    public function setClientDeviceId($clientDeviceId)
    {
        $this->clientDeviceId = $clientDeviceId;
    }
    
    public function getSalt()
    {
        return $this->salt;
    }

    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

        
    public function __construct()
    {
        $dateTime = new \DateTime();
        $this->salt = uniqid();
        $this->createdTime = $dateTime;
        $this->lastLoginTime = $dateTime;
    }

    public function objectVariables()
    {
        return get_object_vars($this);
    }

    public function verifyLogin($credential)
    {
        return $credential == $this->getPassword() ? true : false;
    }

}