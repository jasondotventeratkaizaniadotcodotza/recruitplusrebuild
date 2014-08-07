<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EmailAddress
 *
 * @author Csabi
 */
class RM_Validate_EmailAddress extends Zend_Validate_EmailAddress {

    protected $_messageTemplates = array(
        self::INVALID            => "'%value%' is not a valid email address",
        self::INVALID_FORMAT     => "'%value%' is not a valid email address",
        self::INVALID_HOSTNAME   => "'%value%' is not a valid email address",
        self::INVALID_MX_RECORD  => "'%value%' is not a valid email address",
        self::INVALID_SEGMENT    => "'%value%' is not a valid email address",
        self::DOT_ATOM           => "'%value%' is not a valid email address",
        self::QUOTED_STRING      => "'%value%' is not a valid email address",
        self::INVALID_LOCAL_PART => "'%value%' is not a valid email address",
        self::LENGTH_EXCEEDED    => "'%value%' exceeds the allowed length",
    );

    /**
     * @param Zend_Validate_Hostname $hostnameValidator OPTIONAL
     * @param int                    $allow             OPTIONAL
     * @return void
     */
    public function setHostnameValidator(RM_Validate_Hostname $hostnameValidator = null, $allow = RM_Validate_Hostname::ALLOW_DNS)
    {
        if (!$hostnameValidator) {
            $hostnameValidator = new RM_Validate_Hostname($allow);
        }

        $this->_options['hostname'] = $hostnameValidator;
        $this->_options['allow']    = $allow;
        return $this;
    }
    
}