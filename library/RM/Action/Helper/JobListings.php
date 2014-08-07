<?php

/**
 * Description of JobListings
 *
 * @author User
 */
class RM_Action_Helper_JobListings extends Zend_Controller_Action_Helper_Abstract
{

    public function getAllJobListings($em)
    {
        $jobListings = $em->getRepository('RM\Entity\JobListing')->findBy(array(
            'jobListingStatus' => array(
                \RM\Entity\JobListing::JOBLISTING_STATUS_PENDING_ID,
                \RM\Entity\JobListing::JOBLISTING_STATUS_ACTIVE_ID,
                \RM\Entity\JobListing::JOBLISTING_STATUS_LOADED_ID
                )));
        foreach ($jobListings as $key => $jobListing) {
            $jobListings[$key] = $this->getEntityValuesFromForeignTables($em, $jobListing);
        }
        return $jobListings;
    }

    public function getEntityValuesFromForeignTables($em, $entity)
    {
        if (is_object($entity)) {
            $entity = $entity->objectVariables();
        }
        $lists = $em->getRepository('RM\Entity\Lists')->getLists();
        foreach ($lists as $list) {
            if (isset($entity[$list['listShortName']])) {
                $listItem = $em->getRepository('RM\Entity\ListItems')
                        ->getListItemByListIdAndItemId($list['id'], $entity[$list['listShortName']]);
                $entity[$list['listShortName']] = $listItem;
            }
        }
        return $entity;
    }

    public function getRecruiterJobListings($em, $recruiter)
    {
        $jobListings = $em->getRepository('RM\Entity\JobListing')
                ->findBy(array('userId' => $recruiter->getId(), 'jobListingStatus' => array(
                \RM\Entity\JobListing::JOBLISTING_STATUS_PENDING_ID,
                \RM\Entity\JobListing::JOBLISTING_STATUS_ACTIVE_ID,
                \RM\Entity\JobListing::JOBLISTING_STATUS_LOADED_ID
                )));
        foreach ($jobListings as $key => $jobListing) {
            $jobListings[$key] = $this->getEntityValuesFromForeignTables($em, $jobListing);
            $jobListings[$key]['applicationCount'] = count($this->getJobApplications($em, $jobListing->getId()));
        }
        return $jobListings;
    }

    public function userCreatedJobListing($em, $user, $jobListingId)
    {
        $recruiterJobListings = $this->getRecruiterJobListings($em, $user);
        $jobListingIdArray = array();
        foreach ($recruiterJobListings as $key => $jobListing) {
            $jobListingIdArray[] = $jobListing['id'];
        }
        return in_array($jobListingId, $jobListingIdArray);
    }

    public function getJobApplications($em, $id)
    {
        return $em->getRepository('RM\Entity\JobApplication')->findBy(array('jobListingId' => $id));
    }

}