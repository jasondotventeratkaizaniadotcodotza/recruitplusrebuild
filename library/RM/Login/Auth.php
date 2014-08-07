<?php

namespace RM\Login;

/**
 * Login Auth
 * 
 * @author Enrico Zimuel (enrico@zimuel.it)
 */
class Auth
{

    private function __construct()
    {
        // private - should not be used
    }

    public static function _getAdapter($options)
    {
        $em = \Zend_Registry::get('em');
        $userService = new \RM\Entity\UserService($em);
        $userEntity = $userService->getEntityByEmail($options['email']);
        $email = $options['email'];
        $password = $userService->generatePassword($userEntity);
        
        $auth = new \Zend_Auth_Adapter_DbTable($options['db'], 'users', 'email', 'password');
        var_dump($email);
        var_dump($userEntity);
        die;
        
        $auth->setIdentity($email)->setCredential($userEntity);
        return $auth;
    }

}