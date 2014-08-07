<?php

/**
 * Description of RM_Validate_GreaterThanSalaryRangeLower
 *
 * @author User
 */
class RM_Validate_GreaterThanSalaryRangeLower extends Zend_Validate_Abstract{

    const INVALID_NUMBER = 'invalidNumber';

    protected $_messageTemplates = array(
        self::INVALID_NUMBER => "'%value%' is less than the lower salary range"
    );

    public function isValid($value, $context = null) {
        $value = (string) $value;
        $this->_setValue($value);
        $upper = intval($value);
        $lower = intval($context['salaryRangeLower']);
        if($upper < $lower){
            $this->_error(self::INVALID_NUMBER);
            return false;
        }
        
        return true;
    }

}