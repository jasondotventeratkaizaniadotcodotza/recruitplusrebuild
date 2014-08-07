<?php

class JobApplicationController extends Zend_Controller_Action
{

    private $em = null;
    private $cacheDriver = null;
    private $formHelper = null;
    private $jobListingHelper = null;
    private $loggedUser = null;

    public function init()
    {
        $this->em = Zend_Registry::get('em');
        $this->cacheDriver = Zend_Registry::get('cacheDriver');
        $this->formHelper = new RM\Form\FormHelper();
        $this->jobListingHelper = new RM_Action_Helper_JobListings();
        if (\Zend_Auth::getInstance()->hasIdentity())
            $this->loggedUser = \Zend_Auth::getInstance()->getIdentity();
    }

    public function indexAction()
    {
        if ($this->loggedUser->getRole() instanceof RM\Entity\Roles) {
            $currentUserRole = $this->loggedUser->getRole()->getRole();
            if (in_array($currentUserRole, array(RM\Entity\Roles::RECRUITER_NAME,
                        RM\Entity\Roles::PREMIUM_RECRUITER_NAME))) {

                $jobListingId = $this->_request->getParam(PARAM_JOBLISTING_ID);
                if (is_numeric($jobListingId) && $jobListingId != 0) {
                    if ($this->jobListingHelper->userCreatedJobListing($this->em, $this->loggedUser, $jobListingId)) {
                        $jobApplications = $this->jobListingHelper->getJobApplications($this->em, $jobListingId);
                        $this->view->jobApplications = $jobApplications;
                    }
                }
            } else {
                $this->_redirect('job-listing');
            }
        }

        $form = $this->formHelper->getForm('jobApplicationStatus');
        $element = $form->getElement(\Application_Form_JobApplicationStatus::JOB_APPLICATION_STATUS);
        $element->removeDecorator('label');
        $this->view->form = $form;
    }
    
    public function changeStatusAction()
    {
        Zend_Layout::getMvcInstance()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        
        $statusId = $this->_getParam('statusId');
        $applicationId = $this->_getParam('applicationId');
        $jobApplication = $this->em->getRepository('RM\Entity\JobApplication')->findOneBy(array('id' => $applicationId));
        if($jobApplication->getJobListingId()->getUserId()->getId() === $this->loggedUser->getId()){
            $jobApplicationService = new \RM\Entity\JobApplicationService($this->em);
            $jobApplication->setJobApplicationStatus($statusId);
            $jobApplicationService->updateEntity($jobApplication);
            $this->_helper->json(true, true);
        } else {
            $this->_helper->json(false, true);
        }
    }

    public function rateApplicationAction()
    {
        Zend_Layout::getMvcInstance()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        
        $clickedStar = $this->_getParam('clickedStar');
        $applicationId = $this->_getParam('applicationId');
        $jobApplication = $this->em->getRepository('RM\Entity\JobApplication')->findOneBy(array('id' => $applicationId));
        
        if($jobApplication->getJobListingId()->getUserId()->getId() === $this->loggedUser->getId()){
            $data = array(
                'userId' => $this->loggedUser,
                'jobApplicationId' => $jobApplication,
                'userRating' => $clickedStar
            );
            $applicationRatingService = new \RM\Entity\ApplicationRatingsService($this->em);
            $applicationRating = $applicationRatingService->makeApplicationRating($data);
            $applicationRatingService->saveEntity($applicationRating);
            
            $this->_helper->json(true, true);
        } else {
            $this->_helper->json(false, true);
        }
    }
}

