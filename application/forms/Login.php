<?php

/**
 * @Description:This class creates the form from which users log into the system
 */
class Application_Form_Login extends RM_Form
{

    const FORM_NAME = 'Login';

    public function __construct($options = null)
    {
        parent::__construct($options);

        $this->setName(self::FORM_NAME);
    }

    public function init()
    {

        $this->addElement('text', 'email', $this->getEmailElementSettings());

        $this->addElement('password', 'password', array(
            'label' => 'Password:',
            'maxlength' => 100,
            'validators' => array(
                array('StringLength', true, array('min' => 4, 'max' => 16))),
            'class' => 'span3',
            'required' => true
        ));

        $this->setElementDecorators($this->getElementDecorators());

        $this->addElement('submit', 'login', array(
            'Label' => 'Login',
            'class' => array('btn', 'btn-primary')
        ));

        $this->addDisplayGroup(array('login'), 'formActions');
        $this->getDisplayGroup('formActions')->setDecorators($this->getDisplayGroupDecorators());
        $this->setDecorators($this->getFormDecorators('span6', 'offset3'));

        $this->getElement('login')->setDecorators(array('ViewHelper'));

        $this->setMethod('POST');
    }

}

