<?php

class LoginController extends Zend_Controller_Action
{

    const INCORRECT_CREDENTIALS = 'Incorrect password supplied for email.';
    const HASH = 'h';

    public $em = null;

    public function init()
    {
        $this->em = Zend_Registry::get('em');
        $this->formHelper = new RM\Form\FormHelper();
    }

    public function indexAction()
    {
        $form = $this->formHelper->getForm(RM\Form\FormHelper::LOGIN);
        if ($this->getRequest()->isPost()) {

            if ($form->isValid($this->_request->getPost())) {
                try {
                    $adapter = new \RM\Auth\Adapter($this->em);

                    $adapter->setTableClass('RM\Entity\User')
                            ->setIdentityColumn('email')
                            ->setCredentialColumn('password')
                            ->setIdentity($form->getValue('email'))
                            ->setCredential($form->getValue('password'));
                    $result = $adapter->authenticate();
                    if ($result->isValid()) {
                        $user = $this->em->getRepository('RM\Entity\User')->findOneBy(array('email' => $result->getIdentity()));
                        if ($this->verifyUser($user)) {
                            $this->startUserAuthSession($user);
                        }
                    } else {
                        $form->getElement('password')->setErrors(array(self::INCORRECT_CREDENTIALS));
                    }
                } catch (Exception $e) {
                    RM_Logger::info($e->getMessage());
                }
            }
        } else {
            $email = $this->_getParam(PARAM_EMAIL);
            if (!empty($email)) {
                $form->getElement('email')->setValue($email);
            }
        }
        $this->view->form = $form;
    }

    /**
     * Logout
     */
    public function logoutAction()
    {
        Zend_Auth::getInstance()->clearIdentity();
        $this->_redirect('login');
    }

    public function checkAction()
    {
        if ($this->getRequest()->isGet()) {
            $hash = $this->_getParam(self::HASH);
            if ($this->isValidHash($hash)) {
                $emailEntity = $this->em->getRepository('RM\Entity\Emails')->findOneBy(array('loginHash' => $hash));
                if ((!empty($emailEntity)) && ($emailEntity instanceof RM\Entity\Emails)) {
                    $expirationDate = new \DateTime();
                    $emailSentAt = $emailEntity->getDateSent();
                    $expirationDate->add(new DateInterval('P' . LINK_EXPIRATION_DAYS . 'D'));
                    if ($emailSentAt < $expirationDate) {
                        $user = $this->em->getRepository('RM\Entity\User')->findOneBy(array('email' => $emailEntity->getRecipient()));

                        if ($this->verifyUser($user)) {
                            $this->startUserAuthSession($user);
                        }
                    } else {
                        $redirectLink = 'index?' . PARAM_MESSAGE . '=' . urlencode(RM\Entity\UserService::EXPIRED_LINK);
                        $this->_redirect($redirectLink);
                    }
                }
            }
        }
    }

    protected function isValidHash($hash)
    {
        if ((strlen($hash) === 64) && (ctype_xdigit($hash))) {
            return true;
        } else {
            $this->_redirect('index');
        }
    }

    protected function updateUserInformation($user)
    {
        if ($user instanceof RM\Entity\User) {
            $user->setLastIpAddress($_SERVER['REMOTE_ADDR']);
            $user->setLastUserAgent($_SERVER['HTTP_USER_AGENT']);
            $user->setLastLoginTime(new \DateTime());
            $userService = new RM\Entity\UserService($this->em);
            $userService->updateEntity($user);
        }
        return $user;
    }

    public function verifyUser($user)
    {
        if ($user instanceof RM\Entity\User) {
            if ($user->getUserStatus() == RM\Entity\User::USER_STATUS_ENABLED_ID) {
                return true;
            } else {
                $redirectLink = 'index?' . PARAM_MESSAGE . '=' . urlencode(RM\Entity\UserService::INACTIVE_ACCOUNT);
                $this->_redirect($redirectLink);
            }
        }
    }

    public function startUserAuthSession($user)
    {
        $user = $this->updateUserInformation($user);
        $auth = Zend_Auth::getInstance();
        $user = $this->updateUserInformation($user);
        $auth->getStorage()->write($user);
        $this->_redirect('job-listing');
    }

}

