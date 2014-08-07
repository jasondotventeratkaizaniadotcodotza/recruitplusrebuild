<?php

namespace RM\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Table(name="attachments")
 * @ORM\Entity(repositoryClass="RM\Entity\Repository\AttachmentRepository")
 * @author Csabi
 */
class Attachment
{
    
    const ATTACHMENT_STATUS_PENDING = 1;
    const ATTACHMENT_STATUS_UPLOADED = 2;
    const ATTACHMENT_STATUS_DELETED = 3;
    const ATTACHMENT_TYPE_CV = 1;
    const ATTACHMENT_TYPE_CERTIFICATION = 2;
    const ATTACHMENT_TYPE_OTHER = 3;

    /**
     * @var integer $id 
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     *
     * @var User
     * @ORM\ManyToOne(targetEntity="User", fetch="EAGER")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="userId", referencedColumnName="id")
     * })
     */
    private $userId;

    /**
     *
     * @var integer $attachmentStatus 
     * @ORM\Column(type="integer", nullable=false)
     */
    private $attachmentStatus;

    /**
     *
     * @var integer $attachementType 
     * @ORM\Column(type="integer", nullable=false)
     */
    private $attachementType;

    /**
     *
     * @var string $attachmentPath
     * @ORM\Column(type="string", nullable=true)
     */
    private $attachmentPath;

    /**
     *
     * @var string $attachmentDescription
     * @ORM\Column(type="string", nullable=true)
     */
    private $attachmentDescription;

    /**
     *
     * @var type $createdTime
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $createdDate;

    /**
     *
     * @var type $createdTime
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $lastModifiedDate;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    public function getAttachmentStatus()
    {
        return $this->attachmentStatus;
    }

    public function setAttachmentStatus($attachmentStatus)
    {
        $this->attachmentStatus = $attachmentStatus;
    }

    public function getAttachementType()
    {
        return $this->attachementType;
    }

    public function setAttachementType($attachementType)
    {
        $this->attachementType = $attachementType;
    }

    public function getAttachmentPath()
    {
        return $this->attachmentPath;
    }

    public function setAttachmentPath($attachmentPath)
    {
        $this->attachmentPath = $attachmentPath;
    }

    public function getAttachmentDescription()
    {
        return $this->attachmentDescription;
    }

    public function setAttachmentDescription($attachmentDescription)
    {
        $this->attachmentDescription = $attachmentDescription;
    }

    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    public function setCreatedDate($createdDate)
    {
        $this->createdDate = $createdDate;
    }

    public function getLastModifiedDate()
    {
        return $this->lastModifiedDate;
    }

    public function setLastModifiedDate($lastModifiedDate)
    {
        $this->lastModifiedDate = $lastModifiedDate;
    }

    public function __construct()
    {
        $dateTime = new \DateTime();
        $this->createdDate = $dateTime;
        $this->lastModifiedDate = $dateTime;
    }

}
