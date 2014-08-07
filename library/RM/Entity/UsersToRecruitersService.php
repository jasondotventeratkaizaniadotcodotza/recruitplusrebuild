<?php

namespace RM\Entity;

use Doctrine\ORM\EntityManager;
use RM\Entity\UsersToRecruiters;

/**
 * Description of RecruiterService
 *
 * @author Csabi
 */
class UsersToRecruitersService extends AbstractService
{

    public function __construct(EntityManager $em)
    {
        parent::__construct($em);
        $this->entity = $this->getNewUsersToRecruitersEntity();
    }

    public function makeUserToRecruiterConnection($userEntity, $recruiterEntity)
    {
        $this->entity->setUserId($userEntity);
        $this->entity->setRecruiterId($recruiterEntity);
        $this->entity->setRecruiterUserType(UsersToRecruiters::RECRUITER_USER_TYPE_SUPER_USER_ID);
        $this->entity->setApplicationNotifications(UsersToRecruiters::RECRUITER_USER_APPLICATION_NOTIFICATION_NO_NOTIFICATIONS);
        return $this->entity;
    }

    public function getNewUsersToRecruitersEntity()
    {
        return new \RM\Entity\UsersToRecruiters();
    }

    public function getRecruiterByUserId($id)
    {
        $usersToRecruitersEntity = $this->em->getRepository('RM\Entity\UsersToRecruiters')
                ->findOneBy(array('userId' => $id));
        return $usersToRecruitersEntity->getRecruiterId();
    }

}
