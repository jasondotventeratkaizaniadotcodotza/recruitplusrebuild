<?php

namespace RM\Entity;

use Doctrine\ORM\EntityManager;
use RM\Entity\JobListing;
use RM\Entity\Repository\JobListingRepository;

/**
 * Description of JobListingService
 *
 * @author Csabi
 */
class JobListingService extends AbstractService
{

    protected $em;
    protected $entity;
    protected $rep;

    public function __construct(EntityManager $em)
    {
        parent::__construct($em);
        $this->entity = $this->getNewJobListingEntity();
    }

    public function makeJobListing($jobListing)
    {
        $this->entity->setJobListingStatus($jobListing['jobListingStatus']);
        $this->entity->setUserId($jobListing['userId']);
        $this->entity->setAdvertisedBy($jobListing['advertisedBy']);
        $this->entity->setStartTime(\DateTime::createFromFormat('d/m/Y H:i', $jobListing['startTime']));
        $this->entity->setEndTime(\DateTime::createFromFormat('d/m/Y H:i', $jobListing['endTime']));
        $this->entity->setTitle($jobListing['title']);
        $this->entity->setJobListingType($jobListing['jobListingType']);
        $this->entity->setEmploymentEquity($jobListing['employmentEquity']);
        $this->entity->setIndustry($jobListing['industry']);
        $this->entity->setCategory($jobListing['category']);
        $this->entity->setSalaryRangeLower($jobListing['salaryRangeLower']);
        $this->entity->setSalaryRangeUpper($jobListing['salaryRangeUpper']);
        $this->entity->setLocationId($jobListing['locationPostalCode']);
        $this->entity->setDescription(htmlentities($jobListing['description']));
        $this->entity->setExperienceLevel($jobListing['experienceLevel']);
        $this->entity->setExperienceYears($jobListing['experienceYears']);
        $this->entity->setDesiredSkillsExperience(htmlentities($jobListing['desiredSkillsExperience']));
        $this->entity->setCompanyDescription(htmlentities($jobListing['companyDescription']));
        $this->entity->setResponseEmail($jobListing['responseEmail']);
        $this->entity->setApplicationUrl($jobListing['applicationUrl']);
        $this->entity->setCreatedTime(new \DateTime("now"));
        $this->entity->setLastModifiedTime(new \DateTime("now"));
        $this->entity->setCompanyName($jobListing['companyName']);
        return $this->entity;
    }

    public function getNewJobListingEntity()
    {
        return new \RM\Entity\JobListing();
    }

}