<?php

namespace RM\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Table(name="recruiters",uniqueConstraints={@ORM\UniqueConstraint(name="unique_company_name", columns={"companyName"})})
 * @ORM\Entity(repositoryClass="RM\Entity\Repository\RecruiterRepository")
 * @author Csabi
 */
class Recruiter
{
    
    const PAYMENT_PERIOD_ADHOC_ID = 1;
    const PAYMENT_PERIOD_MONTHLY_ID = 2;
    const PAYMENT_PERIOD_YEARLY_ID = 3;
    const RECRUITER_STATUS_PENDING = 1;
    const RECRUITER_STATUS_ENABLED = 2;
    const RECRUITER_STATUS_DISABLED = 3;
    const RECRUITER_STATUS_BLACKLISTED = 4;

    /**
     * @var integer $id 
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     *
     * @var integer $recruiterStatus 
     * @ORM\Column(type="integer", nullable=false)
     */
    private $recruiterStatus;

    /**
     *
     * @var string $companyName 
     * @ORM\Column(type="string", nullable=true)
     */
    private $companyName;

    /**
     *
     * @var string $companyLogoPath
     * @ORM\Column(type="string", nullable=true)
     */
    private $companyLogoPath;

    /**
     *
     * @var integer $companyType
     * @ORM\Column(type="integer", nullable=true)
     */
    private $companyType;

    /**
     *
     * @var string $vatNumber
     * @ORM\Column(type="string", nullable=true)
     */
    private $vatNumber;

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
     * @var integer $paymentPeriod
     * @ORM\Column(type="integer", nullable=false)
     */
    private $paymentPeriod;

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

    public function getRecruiterStatus()
    {
        return $this->recruiterStatus;
    }

    public function setRecruiterStatus($recruiterStatus)
    {
        $this->recruiterStatus = $recruiterStatus;
    }

    public function getCompanyName()
    {
        return $this->companyName;
    }

    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;
    }

    public function getCompanyLogoPath()
    {
        return $this->companyLogoPath;
    }

    public function setCompanyLogoPath($companyLogoPath)
    {
        $this->companyLogoPath = $companyLogoPath;
    }

    public function getCompanyType()
    {
        return $this->companyType;
    }

    public function setCompanyType($companyType)
    {
        $this->companyType = $companyType;
    }

    public function getVatNumber()
    {
        return $this->vatNumber;
    }

    public function setVatNumber($vatNumber)
    {
        $this->vatNumber = $vatNumber;
    }

    public function getLocationId()
    {
        return $this->locationId;
    }

    public function setLocationId($locationId)
    {
        $this->locationId = $locationId;
    }

    public function getPaymentPeriod()
    {
        return $this->paymentPeriod;
    }

    public function setPaymentPeriod($paymentPeriod)
    {
        $this->paymentPeriod = $paymentPeriod;
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