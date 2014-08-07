<?php

namespace RM\Entity;

use Doctrine\ORM\EntityManager;
use RM\Entity\JobApplication;

/**
 * Description of JobApplicationService
 *
 * @author Csabi
 */
class JobApplicationService extends AbstractService
{

    public function __construct(EntityManager $em)
    {
        parent::__construct($em);
        $this->entity = $this->createJobApplication();
    }

    public function makeJobApplication($jobListingEntity, $jobSeekerEntity, $data = null)
    {
        $this->entity->setApplicationEntryStatus(JobApplication::ENTRY_STATUS_NEW_ID);
        $this->entity->setJobApplicationStatus(JobApplication::JOB_APPLICATION_STATUS_NOT_SPECIFIED_ID);
        $this->entity->setJobAlerts(JobApplication::JOB_ALERTS_NOT_SPECIFIED_ID);
        $this->entity->setUserId($jobSeekerEntity);
        $this->entity->setJobListingId($jobListingEntity);
        if(isset($data['byline'])) $this->entity->setByline (htmlentities($data['byline']));
        if(isset($data['coverLetter'])) $this->entity->setCoverLetter(htmlentities($data['coverLetter']));
        if(isset($data['cvAttachmentId'])) $this->entity->setCvAttachmentId ($data['cvAttachmentId']);
        if(isset($data['jobAlerts'])) $this->entity->setJobAlerts ($data['jobAlerts']);
        return $this->entity;
    }

    public function createJobApplication()
    {
        return new \RM\Entity\JobApplication();
    }

}
