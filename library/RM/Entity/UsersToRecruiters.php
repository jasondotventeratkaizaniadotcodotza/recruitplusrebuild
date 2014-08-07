<?php

namespace RM\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Table(name="users_to_recruiters")
 * @ORM\Entity(repositoryClass="RM\Entity\Repository\UsersToRecruitersRepository")
 * @author Csabi
 */
class UsersToRecruiters
{
    
    const RECRUITER_USER_TYPE_SUPER_USER_ID = 1;
    const RECRUITER_USER_TYPE_STANDARD_USER_ID = 2;
    const RECRUITER_USER_APPLICATION_NOTIFICATION_NO_NOTIFICATIONS = 1;
    const RECRUITER_USER_APPLICATION_NOTIFICATION_DAILY_DIGEST = 2;
    const RECRUITER_USER_APPLICATION_NOTIFICATION_REAL_TIME = 3;

    /**
     * @var integer $id 
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     *
     * @var User
     * @ORM\ManyToOne(targetEntity="User", fetch="EAGER")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="userId", referencedColumnName="id")
     * })
     */
    private $userId;

    /**
     *
     * @var Recruiter
     * @ORM\ManyToOne(targetEntity="Recruiter", fetch="EAGER")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="recruiterId", referencedColumnName="id")
     * })
     */
    private $recruiterId;

    /**
     *
     * @var integer $applicationNotifications 
     * @ORM\Column(type="integer", nullable=false)
     */
    private $applicationNotifications;

    /**
     *
     * @var integer $recruiterUserType 
     * @ORM\Column(type="integer", nullable=false)
     */
    private $recruiterUserType;

    /**
     *
     * @var type $createdTime
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $createdDate;

    /**
     *
     * @var type $createdTime
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $lastModifiedDate;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    public function getRecruiterId()
    {
        return $this->recruiterId;
    }

    public function setRecruiterId($recruiterId)
    {
        $this->recruiterId = $recruiterId;
    }

    public function getApplicationNotifications()
    {
        return $this->applicationNotifications;
    }

    public function setApplicationNotifications($applicationNotifications)
    {
        $this->applicationNotifications = $applicationNotifications;
    }

    public function getRecruiterUserType()
    {
        return $this->recruiterUserType;
    }

    public function setRecruiterUserType($recruiterUserType)
    {
        $this->recruiterUserType = $recruiterUserType;
    }

    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    public function setCreatedDate($createdDate)
    {
        $this->createdDate = $createdDate;
    }

    public function getLastModifiedDate()
    {
        return $this->lastModifiedDate;
    }

    public function setLastModifiedDate($lastModifiedDate)
    {
        $this->lastModifiedDate = $lastModifiedDate;
    }

    public function __construct()
    {
        $dateTime = new \DateTime();
        $this->createdDate = $dateTime;
        $this->lastModifiedDate = $dateTime;
    }

}