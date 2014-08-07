<?php

namespace RM\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Table(name="job_applications")
 * @ORM\Entity(repositoryClass="RM\Entity\Repository\JobApplicationRepository")
 * @author Csabi
 */
class JobApplication
{

    const ENTRY_STATUS_NEW_ID = 1;
    const ENTRY_STATUS_COMPLETED_ID = 2;
    const ENTRY_STATUS_DELETED_ID = 3;
    const ENTRY_STATUS_BLACKLISTED_ID = 4;
    const JOB_APPLICATION_STATUS_NOT_SPECIFIED_ID = -1;
    const JOB_APPLICATION_STATUS_SHORT_LIST_ID = 1;
    const JOB_APPLICATION_STATUS_MAYBE_ID = 2;
    const JOB_APPLICATION_STATUS_REJECTED_ID = 3;
    const JOB_APPLICATION_STATUS_INTERVIEWING_ID = 4;
    const JOB_APPLICATION_STATUS_OFFER_MADE_ID = 5;
    const JOB_APPLICATION_STATUS_APPOINTED_ID = 6;
    const JOB_ALERTS_NOT_SPECIFIED_ID = -1;
    const JOB_ALERTS_YES_ID = 1;
    const JOB_ALERTS_NO_ID = 2;

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
     * @var User
     * @ORM\ManyToOne(targetEntity="JobListing", fetch="EAGER")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="jobListingId", referencedColumnName="id", nullable=true)
     * })
     */
    private $jobListingId;

    /**
     *
     * @var Attachment
     * @ORM\ManyToOne(targetEntity="Attachment", fetch="EAGER")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="cvAttachmentId", referencedColumnName="id", nullable=true)
     * })
     */
    private $cvAttachmentId;

    /**
     *
     * @var integer $applicationEntryStatus 
     * @ORM\Column(type="integer", nullable=false)
     */
    private $applicationEntryStatus;

    /**
     *
     * @var integer $jobApplicationStatus 
     * @ORM\Column(type="integer", nullable=false)
     */
    private $jobApplicationStatus;

    /**
     *
     * @var string $byline 
     * @ORM\Column(type="string", length=160, nullable=true)
     */
    private $byline;

    /**
     *
     * @var type $description
     * @ORM\Column(type="text", nullable=true)
     */
    private $coverLetter;

    /**
     *
     * @var integer $jobAlerts 
     * @ORM\Column(type="integer", nullable=false)
     */
    private $jobAlerts;

    /**
     *
     * @var integer $averageRecruiterRating 
     * @ORM\Column(type="integer", nullable=true)
     */
    private $averageRecruiterRating; //TODO:change to float

    /**
     *
     * @var integer $jobAlerts 
     * @ORM\Column(type="integer", nullable=true)
     */
    private $source;

    /**
     *
     * @var string $custom1 
     * @ORM\Column(type="string", nullable=true)
     */
    private $custom1;

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

    public function getJobListingId()
    {
        return $this->jobListingId;
    }

    public function setJobListingId($jobListingId)
    {
        $this->jobListingId = $jobListingId;
    }

    public function getApplicationEntryStatus()
    {
        return $this->applicationEntryStatus;
    }

    public function setApplicationEntryStatus($applicationEntryStatus)
    {
        $this->applicationEntryStatus = $applicationEntryStatus;
    }

    public function getJobApplicationStatus()
    {
        return $this->jobApplicationStatus;
    }

    public function setJobApplicationStatus($jobApplicationStatus)
    {
        $this->jobApplicationStatus = $jobApplicationStatus;
    }

    public function getByline()
    {
        return $this->byline;
    }

    public function setByline($byline)
    {
        $this->byline = $byline;
    }

    public function getCoverLetter()
    {
        return $this->coverLetter;
    }

    public function setCoverLetter($coverLetter)
    {
        $this->coverLetter = $coverLetter;
    }

    public function getCvAttachmentId()
    {
        return $this->cvAttachmentId;
    }

    public function setCvAttachmentId($cvAttachmentId)
    {
        $this->cvAttachmentId = $cvAttachmentId;
    }

    public function getJobAlerts()
    {
        return $this->jobAlerts;
    }

    public function setJobAlerts($jobAlerts)
    {
        $this->jobAlerts = $jobAlerts;
    }

    public function getAverageRecruiterRating()
    {
        return $this->averageRecruiterRating;
    }

    public function setAverageRecruiterRating($averageRecruiterRating)
    {
        $this->averageRecruiterRating = $averageRecruiterRating;
    }

    public function getSource()
    {
        return $this->source;
    }

    public function setSource($source)
    {
        $this->source = $source;
    }

    public function getCustom1()
    {
        return $this->custom1;
    }

    public function setCustom1($custom1)
    {
        $this->custom1 = $custom1;
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