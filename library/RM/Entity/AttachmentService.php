<?php

namespace RM\Entity;

use Doctrine\ORM\EntityManager;
use RM\Entity\Attachment;

/**
 * Description of JobListingService
 *
 * @author Csabi
 */
class AttachmentService extends AbstractService
{

    public function __construct(EntityManager $em)
    {
        parent::__construct($em);
        $this->entity = $this->getNewAttachmentEntity();
    }

    public function createAttachment($user, $file)
    {
        $this->entity->setUserId($user);
        $this->entity->setAttachmentStatus(Attachment::ATTACHMENT_STATUS_UPLOADED);
        $this->entity->setAttachementType(Attachment::ATTACHMENT_TYPE_CV);
        $this->entity->setAttachmentPath($this->generateUserPath($user, $file));
        return $this->entity;
    }

    public function getNewAttachmentEntity()
    {
        return new \RM\Entity\Attachment();
    }

    public function generateUserPath($user, $file)
    {
        $id = $user->getId();
        $folder = ATTACHMENTS_PATH . '/';
        switch ($id) {
            case $this->checkRange($id, 0, 10):
                $folder .= '00' . $id . '/';
                break;
            case $this->checkRange($id, 9, 100):
                $folder .= '0' . $id . '/';
                break;
            case $this->checkRange($id, 99, 1000):
                $folder .= $id . '/';
                break;
            default:
                $idStr = '' . $id;
                $folder .= substr($idStr, strlen($idStr) - 3, 3) . '/';
                break;
        }
        if (!is_dir($folder)) {
            mkdir($folder, 0777);
        }
        
        chmod($folder, 777);
        
        $filename = $this->getGeneratedFilename($user, $file);
        $path = $folder . $filename;
        return $path;
    }

    public function checkRange($int, $min, $max)
    {
        return ($int > $min && $int < $max);
    }

    public function getGeneratedFilename($user, $file)
    {
        $extension = explode('.', $file);
        $justExtension = $extension[count($extension) - 1];
        unset($extension[count($extension) - 1]);
        $noExtension = implode('', $extension);
        $date = new \DateTime();
        return $user->getId() . '_' . $date->format('dmYHis') . '_' . ereg_replace("[^A-Za-z0-9]", "", $noExtension) . '.' . $justExtension;
    }

}