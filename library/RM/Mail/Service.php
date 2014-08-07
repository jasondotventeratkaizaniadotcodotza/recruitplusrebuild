<?php

namespace RM\Mail;

/**
 * Description of Service
 *
 * @author Csabi
 */
class Service
{

    public static $algorithm = 'sha256';

    const CONFIRM = 'confirm';
    const CONFIRM_JOB_APPLICATION = 'confirmJobApplication';
    
    public static $publicSalt = '!!!r3crui7@@@m4n4g3m3n7###';

    public $email = null;
    private $loginHash = null;
    private $emailType = null;
    private $timeSent = null;
    
    public $options = array(
        self::CONFIRM => array(
            'subject' => 'Your job advert has been created',
            'template' => 'confirm.phtml',
            'generateLoginHash' => true
        ),
        self::CONFIRM_JOB_APPLICATION => array(
            'subject' => 'Job Application Success',
            'template' => 'confirm-job-application.phtml',
            'generateLoginHash' => true
        )
    );

    public function __construct()
    {
        $this->email = new HtmlMailer();
    }

    public function sendMail($recipient, $type)
    {
        $options = $this->options[$type];
        $this->emailType = $type;
        
        $this->timeSent = new \DateTime();
        
        $this->email->addTo($recipient->getEmail())
                ->setSubject($options['subject'])
                ->setViewParam('recipient', $recipient);
        if ((isset($options['generateLoginHash']) && ($options['generateLoginHash'] === true))) {
            $this->loginHash = $this->generateLoginHash($this->email);
            $this->email->setViewParam('loginHash', $this->loginHash);
        }
        
        $this->logMailInDatabase($this->email, $this->loginHash);
        $this->email->sendHtmlTemplate($options['template']);
    }

    public function logMailInDatabase($email, $loginHash = null)
    {
        $emailEntity = new \RM\Entity\Emails();
        
        $emailEntity->setDateSent($this->timeSent);
        $emailEntity->setEmailType($this->emailType);
        
        $recipients = $email->getRecipients();
        $emailEntity->setRecipient(current($recipients));
        
        $emailEntity->setSender(\RM\Mail\HtmlMailer::$fromEmail);
        $emailEntity->setLoginHash($loginHash);
        
        $em = \Zend_Registry::get('em');
        $emailService = new \RM\Entity\EmailService($em);
        $emailService->saveEntity($emailEntity);
    }

    public function generateLoginHash($email)
    {
        $recipients = $email->getRecipients();
        return hash(self::$algorithm, current($recipients) . $this->timeSent->format('Y-m-d H:i:s') . self::$publicSalt);
    }

}