<?php

namespace RM\Form;

/**
 * Description of FormHelper
 *
 * @author Csabi
 */
class FormHelper {

    const LOGIN = 'login';
    const ACCOUNT_INFO = 'accountInfo';
    const JOB_LISTING = 'jobListing';
    const JOB_APPLICATION = 'jobApplication';
    const PREFIX = 'Form';

    private $cacheDriver = null;

    public function __construct() {
        $this->cacheDriver = \Zend_Registry::get('cacheDriver');
    }

    public function getForm($formName) {
        if ($this->cacheDriver->contains($formName . self::PREFIX)) {
            $form = $this->cacheDriver->fetch($formName . self::PREFIX);
        } else {
            $class = 'Application_Form_' . ucfirst($formName);
            if (true === \Zend_Loader_Autoloader::autoload($class)) {
                $form = new $class();
                $this->cacheDriver->save($formName . self::PREFIX, $form);
            } else {
                $form = false;
            }
        }
        return $form;
    }

    public function getPopulatedJobApplicationForm($data) {
        $form = $this->getForm(\RM\Form\FormHelper::JOB_APPLICATION);

        $dataArray = $data->objectVariables();
        $form->populate($dataArray);
        if ($dataArray['locationId'] instanceof \RM\Entity\Geolocation) {
            $form->getElement('locationPostalCode')->setValue($dataArray['locationId']->getLocation());
        }
        return $form;
    }

    public function isValidJobApplicationPost($form, $data) {
        return $form->getElement('email')->isValid($data['email']);
//        if (isset($data['xml'])) {
//            if ($data['xml'] == '1') {
//                return $form->getElement('email')->isValid($data['email']);
//            } else {
//                return $form->isValid($data);
//            }
//        } else {
//            return $form->isValid($data);
//        }
    }

}