<?php

/**
 * @Description:This class creates the form that saves Job Listings 
 */
class Application_Form_JobListing extends RM_Form
{

    const JOBLISTING_STATUS = 'jobListingStatus';
    const USER_ID = 'userId';
    const ADVERTISED_BY = 'advertisedBy';
    const EMPLOYMENT_EQUITY = 'employmentEquity';
    const JOBLISTING_TYPE = 'jobListingType';
    const INDUSTRY = 'industry';
    const CATEGORY = 'category';
    const EXPERIENCE_LEVEL = 'experienceLevel';
    const EXPERIENCE_YEARS = 'experienceYears';
    const FORM_NAME = 'JobListing';

    public function __construct($options = null)
    {
        parent::__construct($options);

        $this->setName(self::FORM_NAME);
    }

    public function init()
    {
        $greaterThan = new Zend_Validate_GreaterThan(0);
        $greaterThan->setMessage(
                'Please select a valid option (Not Selected is NOT a valid option)', Zend_Validate_GreaterThan::NOT_GREATER
        );

        $this->addElement('radio', self::ADVERTISED_BY, array(
            'multiOptions' => $this->_getMultiOptions(self::ADVERTISED_BY),
            'label' => 'Advertised By:',
            'value' => $this->_getDefaultValue(self::ADVERTISED_BY),
            'label_class' => array('radio', 'pull-left'),
            'separator' => '',
            'required' => true
        ));

        $startDateValidator = new RM_Validate_StartDate();
        $this->addElement('text', 'startTime', array(
            'label' => 'Start Time: ',
            'class' => array('datepicker', 'span4'),
            'description' => '',
            'validators' => array($startDateValidator),
            'required' => true
        ));

        $greaterThanStartTime = new RM_Validate_GreaterThanStartTime();
        $this->addElement('text', 'endTime', array(
            'label' => 'End Time:',
            'class' => array('datepicker', 'span4'),
            'description' => '',
            'validators' => array($greaterThanStartTime),
            'required' => true
        ));

        $this->addElement('text', 'title', array(
            'label' => 'Title:',
            'description' => '',
            'maxlength' => 100,
            'validators' => array(
                array('StringLength', true, array('min' => 0, 'max' => 100))),
            'class' => 'span4',
            'required' => true
        ));

        $this->addElement('select', self::JOBLISTING_TYPE, array(
            'multiOptions' => $this->_getMultiOptions(self::JOBLISTING_TYPE),
            'value' => $this->_getDefaultValue(self::JOBLISTING_TYPE),
            'label' => 'Type:',
            'class' => 'span4',
            'validators' => array($greaterThan),
            'required' => true
        ));

        $this->addElement('radio', self::EMPLOYMENT_EQUITY, array(
            'multiOptions' => $this->_getMultiOptions(self::EMPLOYMENT_EQUITY),
            'label' => 'Employment Equity:',
            'value' => $this->_getDefaultValue(self::EMPLOYMENT_EQUITY),
            'label_class' => array('radio', 'pull-left'),
            'separator' => '',
            'required' => true
        ));

        $this->addElement('select', self::INDUSTRY, array(
            'multiOptions' => $this->_getMultiOptions(self::INDUSTRY),
            'value' => $this->_getDefaultValue(self::INDUSTRY),
            'label' => 'Industry:',
            'class' => 'span4',
            'validators' => array($greaterThan),
            'required' => true
        ));

        $this->addElement('select', self::CATEGORY, array(
            'multiOptions' => $this->_getMultiOptions(self::CATEGORY),
            'value' => $this->_getDefaultValue(self::CATEGORY),
            'label' => 'Category:',
            'class' => 'span4',
            'validators' => array($greaterThan),
            'required' => true
        ));

        $this->addElement('text', 'salaryRangeLower', array(
            'label' => 'Salary Range Lower:',
            'validators' => array(
                array('Digits')),
            'class' => 'span4',
            'required' => false
        ));

        $salaryRangeUpperValidator = new RM_Validate_GreaterThanSalaryRangeLower();
        $this->addElement('text', 'salaryRangeUpper', array(
            'label' => 'Salary Range Upper:',
            'validators' => array(
                array('Digits'),
                $salaryRangeUpperValidator),
            'class' => 'span4',
            'required' => false
        ));

        $locationId = new RM_Validate_LocationId();
        $this->addElement('text', 'locationPostalCode', array(
            'label' => 'Location Postal Code:',
            'class' => 'span4',
            'autocomplete' => 'off',
            'validators' => array($locationId),
            'required' => true
        ));

        $this->addElement('textarea', 'description', array(
            'label' => 'Description:',
            'rows' => 6,
            'class' => 'span4',
            'validators' => array(
                array('StringLength', true, array('min' => 0, 'max' => 4000))),
            'required' => true
        ));

        $this->addElement('select', self::EXPERIENCE_LEVEL, array(
            'multiOptions' => $this->_getMultiOptions(self::EXPERIENCE_LEVEL),
            'value' => $this->_getDefaultValue(self::EXPERIENCE_LEVEL),
            'label' => 'Experience Level:',
            'class' => 'span4',
            'required' => true
        ));

        $this->addElement('select', self::EXPERIENCE_YEARS, array(
            'multiOptions' => $this->_getMultiOptions(self::EXPERIENCE_YEARS),
            'value' => $this->_getDefaultValue(self::EXPERIENCE_YEARS),
            'label' => 'Experience Years:',
            'class' => 'span4',
            'required' => true
        ));

        $this->addElement('textarea', 'desiredSkillsExperience', array(
            'label' => 'Desired Skills Experience:',
            'rows' => 6,
            'class' => 'span4',
            'validators' => array(
                array('StringLength', true, array('min' => 0, 'max' => 2000))),
            'required' => false
        ));

        $this->addElement('textarea', 'companyDescription', array(
            'label' => 'Company Description:',
            'rows' => 6,
            'class' => 'span4',
            'validators' => array(
                array('StringLength', true, array('min' => 0, 'max' => 2000))),
            'required' => false
        ));

        $this->addElement('text', 'responseEmail', array(
            'label' => 'Response Email:',
            'validators' => array(new RM_Validate_EmailAddress()),
            'class' => 'span4',
            'required' => true
        ));

        $this->addElement('text', 'companyName', array(
            'label' => 'Company Name:',
            'description' => '',
            'class' => 'span4',
            'required' => true
        ));

        $tooltipHandler = new \RM\Form\TooltipHandler();
        foreach ($this->getElements() as $formElement) {
            $id = $formElement->getId();
            $tooltip = $tooltipHandler->getFieldTooltip(self::FORM_NAME, $id);
            $formElement->setDescription('<span class="icon-info-sign" title="' . $tooltip . '"></span>');
        }

        $this->setElementDecorators($this->getElementDecorators());

        $this->addElement('submit', 'saveJobListing', array(
            'Label' => 'Save',
            'class' => array('btn', 'btn-primary')
        ));

        $this->addElement('button', 'cancel', array(
            'Label' => 'Cancel',
            'class' => array('btn'),
        ));

        $this->addDisplayGroup(array(
            'title',
            'companyName',
            'industry',
            'category',
            'jobListingType',
            'locationPostalCode',
            'description',
            'responseEmail'
                ), 'basicSettings', array('legend' => 'Basic Settings'));
        $this->addDisplayGroup(array(
            'desiredSkillsExperience',
            'companyDescription',
            'salaryRangeLower',
            'salaryRangeUpper',
            'experienceLevel',
            'experienceYears',
            'employmentEquity',
            'advertisedBy',
            'startTime',
            'endTime'
                ), 'advancedSettings', array('legend' => 'Advanced Settings'));

        $this->addDisplayGroup(array('saveJobListing', 'cancel'), 'formActions');
        $this->getDisplayGroup('formActions')->setDecorators($this->getDisplayGroupDecorators());

        $this->setDecorators($this->getFormDecorators('span6', 'offset3'));

        //Additional Decorations
        $this->getElement(self::ADVERTISED_BY)->setDecorators($this->getRadioDecorators());
        $this->getElement(self::EMPLOYMENT_EQUITY)->setDecorators($this->getRadioDecorators());
        $this->getElement('saveJobListing')->setDecorators(array('ViewHelper'));
        $this->getElement('cancel')->setDecorators(array('ViewHelper'));

        $this->setMethod('POST');
    }

}

