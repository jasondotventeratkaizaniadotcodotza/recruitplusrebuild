<?php

/**
 * App_Plugin_SecurityCheck
 * 
 * @author Enrico Zimuel (enrico@zend.com)
 */
class RM_Plugins_SecurityCheck extends Zend_Controller_Plugin_Abstract
{

    const LOGIN = 'login';
    const INDEX = 'index';

    private $controller;
    private $action;
    private $role;

    /**
     * preDispatch
     * 
     * @param Zend_Controller_Request_Abstract $request
     */
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {

        $this->controller = $this->getRequest()->getControllerName();
        $this->action = $this->getRequest()->getActionName();

        $auth = Zend_Auth::getInstance();
        $redirect = true;
        if ($this->_isAuth($auth)) {
            if ((($this->action == self::INDEX) && ($this->controller == self::LOGIN)) || 
                (($this->action == self::INDEX) && ($this->controller == self::INDEX))) {
//                $this->_initGuestUser($auth);
                $redirect = false;
            } else {

                $user = $auth->getStorage()->read();
                $roleEntity = $user->getRole();
                $this->role = $roleEntity->getRole();

                $acl = $this->_cacheAcl($user);
//                var_dump($acl);die;
//                var_dump($this->_isAllowed($auth, $acl));die;
                if ($this->_isAllowed($auth, $acl)) {
                    $redirect = false;
                }
            }
        } else {
            $redirect = true;
        }

        if ($redirect) {
            $request->setControllerName('index');
            $request->setActionName('index');
        }
    }

    public function _cacheAcl($userEntity)
    {
        $cacheDriver = Zend_Registry::get('cacheDriver');
        if ($cacheDriver->contains('ACL_' . $this->role)) {
            $acl = $cacheDriver->fetch('ACL_' . $this->role);
        } else {
            $acl = new \RM\Login\Acl(\Zend_Registry::get('em'), $userEntity);
            $cacheDriver->save('ACL_' . $this->role, $acl);
        }
        return $acl;
    }

    /**
     * Check user identity using Zend_Auth
     * 
     * @param Zend_Auth $auth
     * @return boolean
     */
    private function _isAuth(Zend_Auth $auth)
    {
        if (!empty($auth) && ($auth instanceof Zend_Auth)) {

            if ($auth->hasIdentity()) {
                return true;
            } else {
                $isGuest = $this->_initGuestUser($auth);
                return $isGuest;
            }
        }
        return false;
    }

    /**
     * Check permission using \Zend_Auth and \Zend_Acl
     * 
     * @param \Zend_Auth $auth
     * @param \Zend_Acl $acl
     * @return boolean
     */
    private function _isAllowed(\Zend_Auth $auth, \Zend_Acl $acl)
    {
        if (empty($auth) || empty($acl) ||
                !($auth instanceof \Zend_Auth) ||
                !($acl instanceof \Zend_Acl)) {
            return false;
        }
        $resources = array(
            '*/*',
            $this->controller . '/*',
            $this->controller . '/' . $this->action
        );
        $result = false;
        foreach ($resources as $res) {
            if ($acl->has($res)) {
                $result = $acl->isAllowed($this->role, $res);
            }
        }
        return $result;
    }

    public function _initGuestUser(Zend_Auth $auth)
    {
        $guest = new \RM\Entity\User();
        $guest->setFirstName(RM\Entity\User::GUEST);

        $em = Zend_Registry::get('em');
        $role = $em->getRepository('RM\Entity\Roles')->findOneBy(array('id' => RM\Entity\Roles::GUEST));
        $guest->setRole($role);
        $this->role = $role->getRole();
        $auth->getStorage()->write($guest);

        $this->_cacheAcl($guest);

        return true;
    }

}
