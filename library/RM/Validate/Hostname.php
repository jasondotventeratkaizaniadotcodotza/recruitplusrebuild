<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Hostname
 *
 * @author Csabi
 */
class RM_Validate_Hostname extends Zend_Validate_Hostname{
    protected $_messageTemplates = array(
        self::CANNOT_DECODE_PUNYCODE  => "",
        self::INVALID                 => "",
        self::INVALID_DASH            => "",
        self::INVALID_HOSTNAME        => "",
        self::INVALID_HOSTNAME_SCHEMA => "",
        self::INVALID_LOCAL_NAME      => "",
        self::INVALID_URI             => "",
        self::IP_ADDRESS_NOT_ALLOWED  => "",
        self::LOCAL_NAME_NOT_ALLOWED  => "",
        self::UNDECIPHERABLE_TLD      => "",
        self::UNKNOWN_TLD             => "",
    );
}
?>
