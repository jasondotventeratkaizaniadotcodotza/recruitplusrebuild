<?php

/**
 * @Description:This class creates the form from which users can register or modify their account settings
 */
class Application_Form_AccountInfo extends RM_Form {

    const FORM_NAME = 'AccountInfo';
    const ACCOUNT_TYPE = 'accountType';

    public function __construct($options = null) {
        parent::__construct($options);

        $this->setName(self::FORM_NAME);
    }

    public function init() {
        
        $this->addElement('text', 'firstName', array(
            'label' => 'First name:',
            'description' => '',
            'maxlength' => 100,
            'validators' => array(
                array('StringLength', true, array('min' => 0, 'max' => 100))),
            'class' => 'span3',
            'required' => true
        ));
        
        $this->addElement('text', 'lastName', array(
            'label' => 'Last name:',
            'description' => '',
            'maxlength' => 100,
            'validators' => array(
                array('StringLength', true, array('min' => 0, 'max' => 100))),
            'class' => 'span3',
            'required' => true
        ));
        
        $this->addElement('text', 'email', $this->getEmailElementSettings());
        
        $this->addElement('password', 'password', array(
            'label' => 'Password:',
            'maxlength' => 100,
            'validators' => array(
                array('StringLength', true, array('min' => 4, 'max' => 16))),
            'class' => 'span3',
            'required' => true
        ));
        
        $this->addElement('password', 'passwordAgain', array(
            'label' => 'Re-type password:',
            'maxlength' => 100,
            'validators' => array(
                array('StringLength', true, array('min' => 4, 'max' => 16))),
            'class' => 'span3',
            'required' => true
        ));
        
        $this->addElement('radio', self::ACCOUNT_TYPE, array(
            'multiOptions' => $this->_getMultiOptions(self::ACCOUNT_TYPE),
            'label' => 'Select one',
            'value' => $this->_getDefaultValue(self::ACCOUNT_TYPE),
            'label_class' => array('radio', 'pull-left'),
            'separator' => '',
            'required' => true
        ));

        $this->setElementDecorators($this->getElementDecorators());

        $this->addElement('submit', 'login', array(
            'Label' => 'Save',
            'class' => array('btn', 'btn-primary')
        ));
        
        $this->addElement('button', 'cancel', array(
            'Label' => 'Cancel',
            'class' => array('btn'),
        ));

        $this->addDisplayGroup(array('login', 'cancel'), 'formActions');
        $this->getDisplayGroup('formActions')->setDecorators($this->getDisplayGroupDecorators());
        $this->setDecorators($this->getFormDecorators('span6', 'offset0'));
        
        $this->getElement(self::ACCOUNT_TYPE)->setDecorators($this->getRadioDecorators());
        $this->getElement('login')->setDecorators(array('ViewHelper'));
        $this->getElement('cancel')->setDecorators(array('ViewHelper'));

        $this->setMethod('POST');
    }
}

