<?php

/**
 * @Description:This class creates the form that saves Job Listings 
 */
class Application_Form_JobApplicationStatus extends RM_Form
{

    const FORM_NAME = 'JobApplication';
    const JOB_APPLICATION_STATUS = 'jobApplicationStatus';

    public function __construct($options = null)
    {
        parent::__construct($options);

        $this->setName(self::FORM_NAME);
    }

    public function init()
    {
        $this->addElement('select', self::JOB_APPLICATION_STATUS, array(
            'multiOptions' => $this->_getMultiOptions(self::JOB_APPLICATION_STATUS),
            'value' => $this->_getDefaultValue(self::JOB_APPLICATION_STATUS),
            'class' => 'span2',
            'required' => true
        ));
        
    }

}