<?php

class GeolocationController extends Zend_Controller_Action
{

    public function init()
    {
        Zend_Layout::getMvcInstance()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $this->em = Zend_Registry::get('em');
        $this->cacheDriver = \Zend_Registry::get('cacheDriver');
    }

    public function indexAction()
    {
        // action body
    }

    public function getLocationsAction()
    {
        $postalCodes = array();
        if ($this->cacheDriver->contains('postalCodeList')) {
            $postalCodes = $this->cacheDriver->fetch('postalCodeList');
        } else {
            $postalCodes = $this->em->getRepository('RM\Entity\Geolocation')->getAllPostalCodes();
            $this->cacheDriver->save('postalCodeList', $postalCodes);
        }
        $this->_helper->json($postalCodes, true);
    }

}