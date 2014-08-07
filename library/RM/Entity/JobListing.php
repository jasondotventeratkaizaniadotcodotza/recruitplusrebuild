<?php

namespace RM\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Description of JobListing
 * @ORM\Table(name="job_listings")
 * @ORM\Entity(repositoryClass="RM\Entity\Repository\JobListingRepository")
 * @author Csabi
 */
class JobListing
{

    const JOBLISTING_STATUS_LOADED_ID = 1;
    const JOBLISTING_STATUS_PENDING_ID = 2;
    const JOBLISTING_STATUS_ACTIVE_ID = 3;
    const JOBLISTING_STATUS_DELETED_ID = 4;

    /**
     * @var integer $id 
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     *
     * @var integer $jobListingStatus 
     * @ORM\Column(type="integer", nullable=false)
     */
    private $jobListingStatus;

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
     * @var integer $advertisedBy 
     * @ORM\Column(type="integer", nullable=false)
     */
    private $advertisedBy;

    /**
     *
     * @var date $startTime
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $startTime;

    /**
     *
     * @var date $endTime
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $endTime;

    /**
     *
     * @var string $title 
     * @ORM\Column(type="string", length=100, nullable=false)
     */
    private $title;

    /**
     *
     * @var integer $jobListingType 
     * @ORM\Column(type="integer", nullable=false)
     */
    private $jobListingType;

    /**
     *
     * @var integer $employmentEquity 
     * @ORM\Column(type="integer", nullable=false)
     */
    private $employmentEquity;

    /**
     *
     * @var integer $industry 
     * @ORM\Column(type="integer", nullable=false)
     */
    private $industry;

    /**
     *
     * @var integer $category 
     * @ORM\Column(type="integer", nullable=false)
     */
    private $category;

    /**
     * @var integer $salaryRangeLower
     * @ORM\Column(type="integer", nullable=true)
     */
    private $salaryRangeLower;

    /**
     * @var integer $salaryRangeUpper
     * @ORM\Column(type="integer", nullable=true)
     */
    private $salaryRangeUpper;

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
     * @var type $description
     * @ORM\Column(type="text", nullable=false, length=4000)
     */
    private $description;

    /**
     *
     * @var string $companyName 
     * @ORM\Column(type="string", nullable=true)
     */
    private $companyName;

    /**
     * @var integer $experienceLevel 
     * @ORM\Column(type="integer", nullable=false)
     */
    private $experienceLevel;

    /**
     * @var integer $experienceYears 
     * @ORM\Column(type="integer", nullable=false)
     */
    private $experienceYears;

    /**
     *
     * @var type $desiredSkillsExperience
     * @ORM\Column(type="text", nullable=true, length=2000)
     */
    private $desiredSkillsExperience;

    /**
     *
     * @var type $companyDescription
     * @ORM\Column(type="text", nullable=true, length=2000)
     */
    private $companyDescription;

    /**
     *
     * @var type $responseEmail
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $responseEmail;

    /**
     * @var type $applicationUrl
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $applicationUrl;

    /**
     *
     * @var type $createdTime
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $createdTime;

    /**
     *
     * @var type $lastModifiedTime
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $lastModifiedTime;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getJobListingStatus()
    {
        return $this->jobListingStatus;
    }

    public function setJobListingStatus($jobListingStatus)
    {
        $this->jobListingStatus = $jobListingStatus;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    public function getAdvertisedBy()
    {
        return $this->advertisedBy;
    }

    public function setAdvertisedBy($advertisedBy)
    {
        $this->advertisedBy = $advertisedBy;
    }

    public function getStartTime()
    {
        return $this->startTime;
    }

    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;
    }

    public function getEndTime()
    {
        return $this->endTime;
    }

    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getJobListingType()
    {
        return $this->jobListingType;
    }

    public function setJobListingType($jobListingType)
    {
        $this->jobListingType = $jobListingType;
    }

    public function getEmploymentEquity()
    {
        return $this->employmentEquity;
    }

    public function setEmploymentEquity($employmentEquity)
    {
        $this->employmentEquity = $employmentEquity;
    }

    public function getIndustry()
    {
        return $this->industry;
    }

    public function setIndustry($industry)
    {
        $this->industry = $industry;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function setCategory($category)
    {
        $this->category = $category;
    }

    public function getSalaryRangeLower()
    {
        return $this->salaryRangeLower;
    }

    public function setSalaryRangeLower($salaryRangeLower)
    {
        $this->salaryRangeLower = $salaryRangeLower;
    }

    public function getSalaryRangeUpper()
    {
        return $this->salaryRangeUpper;
    }

    public function setSalaryRangeUpper($salaryRangeUpper)
    {
        $this->salaryRangeUpper = $salaryRangeUpper;
    }

    public function getLocationId()
    {
        return $this->locationId;
    }

    public function setLocationId($locationId)
    {
        $this->locationId = $locationId;
    }

    public function setLocationDescription($locationDescription)
    {
        $this->locationDescription = $locationDescription;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getDesiredSkillsExperience()
    {
        return $this->desiredSkillsExperience;
    }

    public function setDesiredSkillsExperience($desiredSkillsExperience)
    {
        $this->desiredSkillsExperience = $desiredSkillsExperience;
    }

    public function getCompanyDescription()
    {
        return $this->companyDescription;
    }

    public function setCompanyDescription($companyDescription)
    {
        $this->companyDescription = $companyDescription;
    }

    public function getResponseEmail()
    {
        return $this->responseEmail;
    }

    public function setResponseEmail($responseEmail)
    {
        $this->responseEmail = $responseEmail;
    }

    public function getCreatedTime()
    {
        return $this->createdTime;
    }

    public function setCreatedTime($createdTime)
    {
        $this->createdTime = $createdTime;
    }

    public function getLastModifiedTime()
    {
        return $this->lastModifiedTime;
    }

    public function setLastModifiedTime($lastModifiedTime)
    {
        $this->lastModifiedTime = $lastModifiedTime;
    }

    public function getExperienceLevel()
    {
        return $this->experienceLevel;
    }

    public function setExperienceLevel($experienceLevel)
    {
        $this->experienceLevel = $experienceLevel;
    }

    public function getExperienceYears()
    {
        return $this->experienceYears;
    }

    public function setExperienceYears($experienceYears)
    {
        $this->experienceYears = $experienceYears;
    }

    public function getApplicationUrl()
    {
        return $this->applicationUrl;
    }

    public function setApplicationUrl($applicationUrl)
    {
        $this->applicationUrl = $applicationUrl;
    }
    
    public function getCompanyName()
    {
        return $this->companyName;
    }

    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;
    }

    
    public function __construct()
    {
        $this->created = new \DateTime();
    }

    public function objectVariables()
    {
        return get_object_vars($this);
    }

}