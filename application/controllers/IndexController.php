<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        $this->em = Zend_Registry::get('em');
    }

    public function indexAction()
    {
        if ($this->_request->isGet()) {
            $messageParam = $this->_request->getParam(PARAM_MESSAGE);
            if (null !== $messageParam) {
                $service = new \RM\Entity\UserService($this->em);
                $this->view->message = array(
                    'content' => $service->getMessage($messageParam),
                    'type' => MESSAGE_SUCCESS
                );
            }
        }
        $jobListingHelper = new RM_Action_Helper_JobListings();
        $this->view->jobListings = $jobListingHelper->getAllJobListings($this->em);
    }

    public function informationAction()
    {
        // action body
    }

    public function applyAction()
    {
        // action body
    }


}



