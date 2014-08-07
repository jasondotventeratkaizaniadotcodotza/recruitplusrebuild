<?php

/**
 * Description of GreaterThanStartTime
 *
 * @author User
 */
class RM_Validate_GreaterThanStartTime extends Zend_Validate_Abstract{

    const DATE_INVALID = 'dateInvalid';
    const DATE_TOO_FAR = 'dateTooFar';

    protected $_messageTemplates = array(
        self::DATE_INVALID => "'%value%' is earlier than Start Time",
        self::DATE_TOO_FAR => "'%value%' is more than 30 days from Start Time"
    );

    public function isValid($value, $context = null) {
        $value = (string) $value;
        $this->_setValue($value);
        
        $startTime = \DateTime::createFromFormat('d/m/Y H:i', $context['startTime']);
        $endTime = \DateTime::createFromFormat('d/m/Y H:i', $value);
        $startPlus30 = \DateTime::createFromFormat('d/m/Y H:i', $context['startTime']);
        $startPlus30->add(new DateInterval('P1M'));
        
        if($startTime > $endTime){
            $this->_error(self::DATE_INVALID);
            return false;
        }
        if($endTime > $startPlus30){
            $this->_error(self::DATE_TOO_FAR);
            return false;
        }
        return true;
    }

}