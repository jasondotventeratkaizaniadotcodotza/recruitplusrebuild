<?php

class JobListingController extends Zend_Controller_Action
{

    const DEFAULT_JOBLISTING_STATUS = 2;
    const USER_CREATION_ERROR = 'An error occured registering your email. Please try again.';
    const APPLICATION_BASE_URL = 'http://recruit.vagrant/';

    private $em = null;
    private $cacheDriver = null;
    private $formHelper = null;
    private $jobListingHelper = null;

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
                $this->view->jobListings = $this->jobListingHelper->getRecruiterJobListings($this->em, $this->loggedUser);
                $this->view->partial = '/partials/recruiter-job-listings.phtml';
            } else {
                $this->view->jobListings = $this->jobListingHelper->getAllJobListings($this->em);
                $this->view->partial = '/partials/job-listings.phtml';
            }
        }
    }

    public function addAction()
    {
        $flash = $this->_helper->getHelper('flashMessenger');
        if ($flash->hasMessages()) {
            $this->view->message = $flash->getMessages();
        }
        $form = $this->getPopulatedJobListingForm($this->_request->getParam(PARAM_JOBLISTING_ID));


        $now = new \DateTime("now");
        $form->getElement('startTime')->setValue($now->format('d/m/Y H:00'));
        $now->add(new DateInterval('P1M'));
        $form->getElement('endTime')->setValue($now->format('d/m/Y H:00'));
        if ($this->_request->isPost()) {
            $post = $this->_request->getPost();
            if (!$this->loggedUser->isGuest() && $post['responseEmail'] == null) {
                $post['responseEmail'] = $userEmail = $this->loggedUser->getEmail();
            }
            if ($form->isValid($post)) {
                $data = $this->processDataFromForm($form->getValues());
                $instance = new \RM\Entity\JobListingService($this->em);
                $entity = $instance->makeJobListing($data);
                $id = $instance->saveEntity($entity);

                $user = $this->em->getRepository('RM\Entity\User')->findOneBy(array('email' => $entity->getResponseEmail()));
                if ((!empty($user)) && ($user instanceof RM\Entity\User)) {
                    if ($user->getUserStatus() == RM\Entity\User::USER_STATUS_ENABLED_ID) {
                        if ($this->loggedUser->isRecruiter()) {
                            $redirectUrl = 'job-listing';
                        } else {
                            $redirectUrl = 'index?' . PARAM_MESSAGE . '=' . urlencode(\RM\Entity\JobListingService::CONFIRM);
//                            $redirectUrl = 'login?' . PARAM_EMAIL . '=' . urlencode($entity->getResponseEmail());
                        }
                    } else {
                        $redirectUrl = 'index?' . PARAM_MESSAGE . '=' . urlencode(\RM\Entity\JobListingService::CONFIRM);
                    }
                }

                $mailer = new \RM\Mail\Service();
                try {
                    $mailer->sendMail($user, \RM\Mail\Service::CONFIRM);
                } catch (Exception $e) {
                    RM_Logger::info($e->getMessage());
                }
                $this->_redirect($redirectUrl);
            } else {
                $form->getMessages();
            }
        }

        $this->view->form = $form;
    }

    public function deleteAction()
    {
        if ($this->_request->isGet()) {
            $jobListingId = $this->_request->getParam(PARAM_JOBLISTING_ID);
            if (is_numeric($jobListingId) && $jobListingId != 0) {
                if ($this->jobListingHelper->userCreatedJobListing($this->em, $this->loggedUser, $jobListingId)) {
                    $jobListingService = new \RM\Entity\JobListingService($this->em);
                    if ($jobListingService->entityExists('\RM\Entity\JobListing', $jobListingId)) {
                        $jobListing = $jobListingService->getEntityById('\RM\Entity\JobListing', $jobListingId);
                        $jobListing->setJobListingStatus(RM\Entity\JobListing::JOBLISTING_STATUS_DELETED_ID);
                        $jobListingService->updateEntity($jobListing);
                    }
                }
            }
        }
        $this->_redirect('job-listing');
    }

    public function editAction()
    {
        $jobListingId = $this->_request->getParam(PARAM_JOBLISTING_ID);

        if ($this->jobListingHelper->userCreatedJobListing($this->em, $this->loggedUser, $jobListingId)) {
            $form = $this->getPopulatedJobListingForm($jobListingId);
            $form->getElement('startTime')->removeValidator('RM_Validate_StartDate');
            if ($this->_request->isPost()) {
                $data = $this->_request->getPost();
                $data['responseEmail'] = $this->loggedUser->getEmail();
                if ($form->isValid($data)) {
                    $entity = $this->em->getRepository('RM\Entity\JobListing')->findOneBy(array('id' => $jobListingId));
                    if (!empty($entity)) {
                        $data = $this->processDataFromForm($form->getValues());
                        $instance = new \RM\Entity\JobListingService($this->em);
                        $entity = $instance->makeJobListing($data);
                        $entity->setId($jobListingId);

                        $geolocationService = new \RM\Entity\GeolocationService($this->em);
                        $geolocationEntity = $geolocationService->getGeolocationFromString($data['locationPostalCode']);
                        $entity->setLocationId($geolocationEntity);

                        $saved = $instance->updateEntity($entity);
                    }
                    $this->_redirect('job-listing');
                } else {
                    $form->getMessages();
                }
            } else {
                
            }
        } else {
            $this->_redirect('job-listing');
        }
        $this->view->form = $form;
    }

    public function viewAction()
    {
        $jobListingId = $this->_getParam(PARAM_JOBLISTING_ID);
        if (is_numeric($jobListingId)) {
            $jobListingModel = $this->em->getRepository('RM\Entity\JobListing')->findOneBy(array('id' => $jobListingId));
            if (!empty($jobListingModel)) {
                $jobListingModel = $this->jobListingHelper->getEntityValuesFromForeignTables($this->em, $jobListingModel);
            } else {
                $this->_redirect('job-listing');
            }
        } else {
            $this->_redirect('job-listing');
        }
        $this->view->jobListing = $jobListingModel;
    }

    public function processDataFromForm($data)
    {
        if ($data['locationPostalCode'] != '') {
            $postalCodeInformation = explode(', ', $data['locationPostalCode']);
            $postalCode = $this->em->getRepository('RM\Entity\Geolocation')
                    ->findOneBy(array(
                'postalCode' => $postalCodeInformation[0],
                'placeName' => $postalCodeInformation[1]
                    ));
            $data['locationPostalCode'] = $postalCode;
        }
        if ($data['salaryRangeLower'] == '') {
            $data['salaryRangeLower'] == null;
        }
        if ($data['salaryRangeUpper'] == '') {
            $data['salaryRangeUpper'] == null;
        }
        $data['applicationUrl'] = self::APPLICATION_BASE_URL; //TODO: where does this link to?
        $userEmail = $data['responseEmail'];
        if (!$this->loggedUser->isGuest() && $data['responseEmail'] == null) {
            $data['responseEmail'] = $userEmail = $this->loggedUser->getEmail();
        }
        $data[Application_Form_JobListing::JOBLISTING_STATUS] = self::DEFAULT_JOBLISTING_STATUS;
        $userService = new \RM\Entity\UserService($this->em);
        $user = $userService->fetchUserId($userEmail, \RM\Entity\Roles::RECRUITER);
        $data[Application_Form_JobListing::USER_ID] = $user;
        if ($data['companyName'] != '') {
            $recruiterService = new \RM\Entity\RecruiterService($this->em);
            $userToRecruiter = $this->em->getRepository('RM\Entity\UsersToRecruiters')->findOneBy(array('userId' => $user));
            $recruiter = $this->em->getRepository('RM\Entity\Recruiter')->findOneBy(array('id' => $userToRecruiter->getRecruiterId()->getId()));
            $recruiter->setCompanyName($data['companyName']);
            $recruiterService->updateEntity($recruiter);
        }

        return $data;
    }

    public function getPopulatedJobListingForm($jobListingId)
    {
        $form = $this->formHelper->getForm(\RM\Form\FormHelper::JOB_LISTING);
        if ((!empty($jobListingId)) && (is_numeric($jobListingId))) {
            $jobListingModel = $this->em->getRepository('RM\Entity\JobListing')->getJobListing($jobListingId);
            $jobListingArray = $jobListingModel->objectVariables();
            foreach ($jobListingArray as $field => $value) {
                if ($value instanceof \RM\Entity\ListItems) {
                    $jobListingArray[$field] = $value->itemId;
                }
            }
            $form->populate($jobListingArray);
            $form->getElement('startTime')->setValue($jobListingArray['startTime']->format('d/m/Y H:i'));
            $form->getElement('endTime')->setValue($jobListingArray['endTime']->format('d/m/Y H:i'));
            $form->getElement('locationPostalCode')->setValue($jobListingModel->getLocationId()->getLocation());
        }
        if (!$this->loggedUser->isGuest()) {
            $form->getElement('responseEmail')->setAttrib('disabled', 'disabled')
                    ->setAttrib('class', array('span4', 'uneditable-input'))
                    ->setValue($this->loggedUser->getEmail());
            $usersToRecruitersService = new \RM\Entity\UsersToRecruitersService($this->em);
            $recruiterEntity = $usersToRecruitersService->getRecruiterByUserId($this->loggedUser->getId());
            $form->getElement('companyName')->setValue($recruiterEntity->getCompanyName());
        }

        return $form;
    }

    public function applyAction()
    {
        try {
            $upload = new Zend_File_Transfer();
            $files = $upload->getFileInfo();

            $cvUploadedByXml = false;

            $jobListingId = $this->_getParam(PARAM_JOBLISTING_ID);

            if (count($files) > 0) {
                foreach ($files as $file) {
                    if ($file['error'] == 0 && $file['type'] == 'application/xml') {
                        $xmlString = file_get_contents($file['tmp_name']);
                        $xmlArray = json_decode(json_encode(simplexml_load_string($xmlString)), TRUE);
                        if (isset($xmlArray['xml'])) {
                            if ($xmlArray['xml'] == '1') {
                                $cvBinary = $xmlArray['cv'];
                                $decodedCV = base64_decode($cvBinary);

                                $realName = $xmlArray['cvFilename'] . '.' . $xmlArray['cvExtension']; 
                                $tmpName = uniqid($xmlArray['cvFilename']) . '.' . $xmlArray['cvExtension'];
                                $tmpFileName = ATTACHMENTS_PATH . '/tmp/' . $tmpName;
                                $handle = fopen($tmpFileName, 'w');

                                fwrite($handle, $decodedCV);
                                $jobListingId = $xmlArray['jobListingId'];
                                $cvUploadedByXml = true;
                            }
                        }
                    }
                }
            }

            $form = $this->formHelper->getPopulatedJobApplicationForm($this->loggedUser);
            
            if (is_numeric($jobListingId)) {
                $jobListingEntity = $this->em->getRepository('RM\Entity\JobListing')->findOneBy(array('id' => $jobListingId));
                if (!empty($jobListingEntity)) {
                    if ($this->_request->isPost()) {
                        if (isset($xmlArray['xml'])) {
                            $data = $xmlArray;
                        } else {
                            $data = $this->_request->getPost();
                        }
                        if ($this->formHelper->isValidJobApplicationPost($form, $data)) {
                            $userService = new \RM\Entity\UserService($this->em);
                            $userEntity = $userService->fetchUserId($data['email'], \RM\Entity\Roles::SEEKER);
                            if ($userEntity instanceof \RM\Entity\User) {
                                if (isset($data['firstName']))
                                    $userEntity->setFirstName($data['firstName']);
                                if (isset($data['lastName']))
                                    $userEntity->setLastName($data['lastName']);
                                $geolocationService = new \RM\Entity\GeolocationService($this->em);
                                if (isset($data['locationPostalCode'])) {
                                    $geolocationEntity = $geolocationService->getGeolocationFromString($data['locationPostalCode']);
                                } else {
                                    $geolocationEntity = $geolocationService->setUndefinedLocation();
                                }

                                $userEntity->setLocationId($geolocationEntity);
                                $userService->updateEntity($userEntity);

                                if (isset($data['allowCvSearch'])) {
                                    $jobSeekerService = new \RM\Entity\JobSeekerService($this->em);
                                    $jobSeekerEntity = $this->em->getRepository('RM\Entity\JobSeeker')->findOneBy(array('userId' => $userEntity->getId()));
                                    $jobSeekerEntity->setCvSearchable($data['allowCvSearch']);
                                    $jobSeekerService->saveEntity($jobSeekerEntity);
                                }

                                $attachmentService = new \RM\Entity\AttachmentService($this->em);
                                if ($cvUploadedByXml === true) {
                                    $attachmentEntity = $attachmentService->createAttachment($userEntity, $tmpName);
                                    $attachmentService->saveEntity($attachmentEntity);
                                    $data['cvAttachmentId'] = $attachmentEntity;
                                    copy($tmpFileName, $attachmentEntity->getAttachmentPath()) or die("Unable to copy.");
                                    unlink($tmpFileName);
                                } else {
                                    $upload = new Zend_File_Transfer();
                                    $files = $upload->getFileInfo();
                                    foreach ($files as $file) {
                                        if ($file['error'] == 0) {
                                            $attachmentEntity = $attachmentService->createAttachment($userEntity, $file['name']);
                                            $attachmentService->saveEntity($attachmentEntity);
                                            $data['cvAttachmentId'] = $attachmentEntity;

                                            move_uploaded_file($file['tmp_name'], $attachmentEntity->getAttachmentPath());
                                        }
                                    }
                                }

                                $jobApplicationService = new \RM\Entity\JobApplicationService($this->em);
                                $jobApplicationEntity = $jobApplicationService->makeJobApplication($jobListingEntity, $userEntity, $data);
                                $jobApplicationService->saveEntity($jobApplicationEntity);

                                $mailer = new \RM\Mail\Service();
                                $mailer->sendMail($userEntity, \RM\Mail\Service::CONFIRM_JOB_APPLICATION);

                                $this->_redirect('job-listing/application-success?' . PARAM_JOBLISTING_ID . '=' . $jobListingId);
                            }
                        } else {
                            $form->getMessages();
                        }
                    } else {
                        
                    }
                } else {
                    $this->_redirect('job-listing');
                }
            } else {
                $this->_redirect('job-listing');
            }
            $this->view->jobListing = $jobListingEntity;
            $this->view->form = $form;
        } catch (Exception $e) {
            RM_Logger::info($e->getMessage());
            RM_Logger::info($e->getTraceAsString());
        }
    }

    public function applicationSuccessAction()
    {
        $jobListingId = $this->_getParam(PARAM_JOBLISTING_ID);

        if (is_numeric($jobListingId)) {
            $jobListingEntity = $this->em->getRepository('RM\Entity\JobListing')->findOneBy(array('id' => $jobListingId));
            if ($jobListingEntity instanceof RM\Entity\JobListing) {
                $this->view->title = $jobListingEntity->getTitle();
                $this->view->jobId = $jobListingEntity->getId();
            } else {
                $this->_redirect('index');
            }
        } else {
            $this->_redirect('index');
        }
    }

}