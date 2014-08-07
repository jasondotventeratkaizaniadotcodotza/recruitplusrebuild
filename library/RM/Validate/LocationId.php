<?php

/**
 * Description of RM_Validate_StartDate
 *
 * @author Csabi
 */
class RM_Validate_LocationId extends Zend_Validate_Abstract
{

    const INVALID_POSTAL_CODE = 'invalidPostalCode';

    protected $_messageTemplates = array(
        self::INVALID_POSTAL_CODE => "'%value%' is invalid",
    );

    public function isValid($value)
    {
        $em = Zend_Registry::get('em');
        $this->_setValue($value);
        if ($value != '') {
            $postalCodeInformation = explode(', ', $value);
            $postalCode = $em->getRepository('RM\Entity\Geolocation')
                    ->findOneBy(array(
                'postalCode' => $postalCodeInformation[0],
                'placeName' => $postalCodeInformation[1]
                    ));
            if ($postalCode instanceof \RM\Entity\Geolocation) {
                return true;
            } else {
                $this->_error(self::INVALID_POSTAL_CODE);
            return false;
            }
        }
    }

}