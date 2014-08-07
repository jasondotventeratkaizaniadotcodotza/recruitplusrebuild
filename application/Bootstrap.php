<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    const MAIL_HOST = 'host';
    const SERVER_NAME = 'SERVER_NAME';

    protected function _initSession()
    {
        $authSession = new Zend_Session_Namespace('Zend_Auth');
        $authSession->setExpirationSeconds(3600);
    }

    public function _initAutoloaderNamespaces()
    {
        require_once APPLICATION_PATH . '/../library/Doctrine/Common/ClassLoader.php';

        $autoloader = \Zend_Loader_Autoloader::getInstance();
        $fmmAutoloader = new \Doctrine\Common\ClassLoader('Bisna');
        $autoloader->pushAutoloader(array($fmmAutoloader, 'loadClass'), 'Bisna');
    }

    protected function _initConfig()
    {
        $config = new Zend_Config($this->getOptions());
        Zend_Registry::set('config', $config);
        return $config;
    }

    protected function _initEntityManager()
    {
        $this->bootstrap('doctrine');
        $container = $this->getResource('doctrine');
        $em = $container->getEntityManager();
        Zend_Registry::set('em', $em);
    }

    protected function _initViewHelpers()
    {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->doctype('HTML5');
        $view->headMeta()->appendHttpEquiv('Content-type', 'text/html;charset=utf-8');
    }

    protected function _initLog()
    {
        if ($this->hasPluginResource('log')) {
            $r = $this->getPluginResource('log');
            $log = $r->getLog();
            Zend_Registry::set('log', $log);
        }
    }

    protected function _initActionHelpers()
    {
        Zend_Controller_Action_HelperBroker::addHelper(new RM_Action_Helper_JobListings());
    }

    protected function _initCacheDriver()
    {
        $cacheDriverOptions = $this->getOption('cacheDriver');
        $memcache = new \Memcache();
        $memcache->connect($cacheDriverOptions['ip'], $cacheDriverOptions['port']);
        $cacheDriver = new \Doctrine\Common\Cache\MemcacheCache();
        $cacheDriver->setMemcache($memcache);
        Zend_Registry::set('cacheDriver', $cacheDriver);
    }

    protected function _initSmtpMail()
    {
        $emailConfig = $this->getOption('email');
        $smtpOptions = $emailConfig['smtpOptions'];
        $smtpHost = $smtpOptions[self::MAIL_HOST];
        unset($smtpOptions[self::MAIL_HOST]);

        $mailTransport = new Zend_Mail_Transport_Smtp($smtpHost, $smtpOptions);

        Zend_Mail::setDefaultTransport($mailTransport);
    }

    protected function _initRecruitPlusUrl()
    {
        $this->bootstrap("frontController");
        $front = $this->getResource("frontController");
        $request = new Zend_Controller_Request_Http();
        $front->setRequest($request);
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $url = 'http://' . $_SERVER[self::SERVER_NAME];
        if ($view->baseUrl() == '')
            $url .= '/';
        else
            $url .= $view->baseUrl();

        define('RECRUITPLUS_URL', $url);
    }

    protected function _initSecurityPlugin()
    {
        $front = Zend_Controller_Front::getInstance();
        $front->registerPlugin(new RM_Plugins_SecurityCheck());
    }

}