<?php

/**
 * @Description:This class creates the form that saves Job Listings 
 */
class Application_Form_JobApplication extends RM_Form
{

    const FILE_INPUT_DECORATOR = 'file.phtml';
    const CV_UPLOAD = 'cvUpload';
    const FORM_NAME = 'JobApplication';
    const ALLOW_CV_SEARCH = 'allowCvSearch';
    const JOB_ALERTS = 'jobAlerts';

    public function __construct($options = null)
    {
        parent::__construct($options);

        $this->setName(self::FORM_NAME);
    }

    public function init()
    {

        $this->addElement('text', 'firstName', array(
            'label' => 'First Name:',
            'description' => '',
            'maxlength' => 100,
            'class' => 'span4',
            'required' => false
        ));

        $this->addElement('text', 'lastName', array(
            'label' => 'Last Name:',
            'description' => '',
            'maxlength' => 100,
            'validators' => array(
                array('StringLength', true, array('min' => 0, 'max' => 100))),
            'class' => 'span4',
            'required' => false
        ));

        $this->addElement('text', 'email', array(
            'label' => 'Email:',
            'validators' => array(new RM_Validate_EmailAddress()),
            'class' => 'span4',
            'required' => true
        ));

        $locationId = new RM_Validate_LocationId();
        $this->addElement('text', 'locationPostalCode', array(
            'label' => 'Location Postal Code:',
            'class' => 'span4',
            'autocomplete' => 'off',
            'validators' => array($locationId),
            'required' => false
        ));

        $this->addElement('text', 'byline', array(
            'label' => 'Byline:',
            'class' => 'span4',
            'maxlength' => 160,
            'validators' => array(
                array('StringLength', true, array('min' => 0, 'max' => 160))),
            'required' => false
        ));

        $this->addElement('textarea', 'coverLetter', array(
            'label' => 'Cover Letter:',
            'rows' => 10,
            'class' => 'span4',
            'validators' => array(
                array('StringLength', true, array('min' => 0, 'max' => 4000))),
            'required' => false
        ));

        $path = ATTACHMENTS_PATH;
        $this->addElement('file', 'cvUpload', array(
            'label' => 'Upload CV:',
            'destination' => $path,
            'validators' => array(
                array('Size', false, '10MB'),
                array('Count', false, 1),
                array('Extension', false, 'txt,doc,docx,pdf,jpg,jpeg,gif,tiff')
            ),
            'required' => false
        ));
        $this->getElement('cvUpload')->setValueDisabled(true);

        $this->addElement('checkbox', 'allowCvSearch', array(
            'label' => 'Allow CV Search:',
            'value' => true,
            'description' => '',
            'class' => 'span1',
            'required' => false
        ));
        
        $this->addElement('checkbox', 'jobAlerts', array(
            'label' => 'Job Alerts:',
            'value' => true,
            'description' => '',
            'class' => 'span1',
            'required' => false
        ));

        $tooltipHandler = new \RM\Form\TooltipHandler();
        foreach ($this->getElements() as $formElement) {
            $id = $formElement->getId();
            $tooltip = $tooltipHandler->getFieldTooltip(self::FORM_NAME, $id);
            $formElement->setDescription('<span class="icon-info-sign pull-right" title="' . $tooltip . '"></span>');
        }

        $this->setElementDecorators($this->getElementDecorators());

        $this->addElement('submit', 'applyForJob', array(
            'Label' => 'Save',
            'class' => array('btn', 'btn-primary')
        ));

        $this->addDisplayGroup(array('applyForJob', 'cancel'), 'formActions');
        $this->getDisplayGroup('formActions')->setDecorators($this->getDisplayGroupDecorators());

        $this->setDecorators($this->getFormDecorators('span6', 'offset3'));

        //Additional Decorations
        $this->getElement('applyForJob')->setDecorators(array('ViewHelper'));
        $this->getElement('cvUpload')->setDecorators($this->getFileDecorators());


        $this->setMethod('POST');
    }

}

