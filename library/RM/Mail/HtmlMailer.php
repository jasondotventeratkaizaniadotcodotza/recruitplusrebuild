<?php

namespace RM\Mail;

/**
 * This class handles email sending 
 *
 * @author User
 */
class HtmlMailer extends \Zend_Mail
{

    static $fromName = 'RecruitPlus';
    static $fromEmail = 'info@recruitplus.com';

    /**
     *
     * @var \Zend_View
     */
    static $_defaultView;

    /**
     * current instance of our Zend_View
     * @var \Zend_View
     */
    protected $_view;

    public function __construct($charset = 'iso-8859-1')
    {
        parent::__construct($charset);
        $this->setFrom(self::$fromEmail, self::$fromName);
        $this->_view = self::getDefaultView();
    }

    protected static function getDefaultView()
    {
        if (self::$_defaultView === null) {
            self::$_defaultView = new \Zend_View;
            self::$_defaultView->setScriptPath(APPLICATION_PATH . '/views/scripts/mail-templates/');
        }
        return self::$_defaultView;
    }

    public function sendHtmlTemplate($template, $encoding = \Zend_Mime::ENCODING_QUOTEDPRINTABLE)
    {
        $html = $this->_view->render($template);
        $this->setBodyHtml($html, $this->getCharset(), $encoding);
        $this->send();
    }

    public function setViewParam($property, $value)
    {
        $this->_view->__set($property, $value);
        return $this;
    }

}
