<?php

class UserController extends Zend_Controller_Action
{

    private $em = null;
    private $cacheDriver = null;
    private $identity = null;

    public function init()
    {
        $this->em = Zend_Registry::get('em');
        $this->cacheDriver = Zend_Registry::get('cacheDriver');
        $this->formHelper = new RM\Form\FormHelper();
    }

    public function indexAction()
    {
        $this->cacheDriver->deleteAll();
    }

    public function informationAction()
    {
        $this->view->form = $this->formHelper->getForm(\RM\Form\FormHelper::ACCOUNT_INFO);
    }

}

