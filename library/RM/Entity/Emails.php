<?php

namespace RM\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Description of JobListing
 * @ORM\Table(name="emails")
 * @ORM\Entity(repositoryClass="RM\Entity\Repository\EmailsRepository")
 * @author Csabi
 */
class Emails
{

    /**
     * @var integer $id 
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     *
     * @var string $sender 
     * @ORM\Column(type="string", nullable=false)
     */
    private $sender;

    /**
     *
     * @var string $recipient 
     * @ORM\Column(type="string", nullable=false)
     */
    private $recipient;

    /**
     *
     * @var string $emailType 
     * @ORM\Column(type="string", nullable=false)
     */
    private $emailType;

    /**
     *
     * @var date $dateSent
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $dateSent;

    /**
     *
     * @var string $loginHash 
     * @ORM\Column(type="string", nullable=false)
     */
    private $loginHash;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getSender()
    {
        return $this->sender;
    }

    public function setSender($sender)
    {
        $this->sender = $sender;
    }

    public function getRecipient()
    {
        return $this->recipient;
    }

    public function setRecipient($recipient)
    {
        $this->recipient = $recipient;
    }

    public function getEmailType()
    {
        return $this->emailType;
    }

    public function setEmailType($emailType)
    {
        $this->emailType = $emailType;
    }

    public function getDateSent()
    {
        return $this->dateSent;
    }

    public function setDateSent($dateSent)
    {
        $this->dateSent = $dateSent;
    }

    public function getLoginHash()
    {
        return $this->loginHash;
    }

    public function setLoginHash($loginHash)
    {
        $this->loginHash = $loginHash;
    }

}