<?php

namespace RM\Entity;

use Doctrine\ORM\EntityManager;

/**
 * Description of AbstractService
 *
 * @author User
 */
abstract class AbstractService
{

    const EXPIRED_LINK = 'expiredLink';
    const CONFIRM = 'confirm';
    const INACTIVE_ACCOUNT = 'inactive';

    public $message = array(
        self::EXPIRED_LINK => 'The link through which you tried to log in has expired. Please login from the login page.',
        self::CONFIRM => 'You have successfully posted the job advert. Please check your email to for confirmation.',
        self::INACTIVE_ACCOUNT => 'Your account is inactive.'
    );
    protected $entity;
    protected $em;

    public function __construct($em)
    {
        $this->em = $em;
    }

    public function saveEntity($entity)
    {
        $this->em->persist($entity);
        $this->em->flush();
        return $entity->getId();
    }

    public function updateEntity($entity)
    {
        $this->em->merge($entity);
        $this->em->flush();
    }

    public function deleteEntity($entity, $entityId)
    {
        $entity = $this->em->find($entity, $entityId);

        if (!$entity)
            echo 'Error deleting item!';
        $this->em->remove($entity);
        $this->em->flush();
    }

    public function entityExists($entity, $entityId)
    {
        $entity = $this->em->find($entity, $entityId);
        return !empty($entity);
    }

    public function getEntityById($entity, $entityId)
    {
        return $this->em->find($entity, $entityId);
    }

    public function getMessage($type)
    {
        if (!isset($this->message[$type])) {
            return null;
        } else {
            return $this->message[$type];
        }
    }

}
