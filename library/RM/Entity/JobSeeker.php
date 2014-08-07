<?php

namespace RM\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Table(name="job_seekers")
 * @ORM\Entity(repositoryClass="RM\Entity\Repository\JobSeekerRepository")
 * @author Csabi
 */
class JobSeeker
{
    
    /**
     * @var integer $id 
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var User
     * @ORM\OneToOne(targetEntity="User")
     * @ORM\JoinColumn(name="userId", referencedColumnName="id")
     */
    private $userId;
    
    /**
     *
     * @var integer $cvSearchable 
     * @ORM\Column(type="integer", nullable=true)
     */
    private $cvSearchable;

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

    
    public function getCvSearchable()
    {
        return $this->cvSearchable;
    }

    public function setCvSearchable($cvSearchable)
    {
        $this->cvSearchable = $cvSearchable;
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
        $this->lastModifiedDate = new \DateTime();
    }

}
