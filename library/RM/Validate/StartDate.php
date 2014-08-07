<?php

/**
 * Description of RM_Validate_StartDate
 *
 * @author Csabi
 */
class RM_Validate_StartDate extends Zend_Validate_Abstract
{
    const DATE_TOO_EARLY = 'dateTooEarly';
    const DATE_TOO_FAR = 'dateTooFar';

    protected $_messageTemplates = array(
        self::DATE_TOO_EARLY => "'%value%' is earlier than today",
        self::DATE_TOO_FAR => "'%value%' is more than 30 days away"
    );

    public function isValid($value)
    {
        $this->_setValue($value);
        
        $now = new \DateTime("now");
        $nowPlus30 = new \DateTime("now");
        $nowPlus30->add(new DateInterval('P1M'));
        $crtVal = \DateTime::createFromFormat('d/m/Y H:00', $value);
//        var_dump($crtVal->format('d/m/Y H:00'));
//        var_dump($now->format('d/m/Y H:00'));
//        die;
        if ($crtVal->format('d/m/Y H:00') < $now->format('d/m/Y H:00')) {
            $this->_error(self::DATE_TOO_EARLY);
            return false;
        }
        if($crtVal > $nowPlus30){
            $this->_error(self::DATE_TOO_FAR);
            return false;
        }

        return true;
    }
}