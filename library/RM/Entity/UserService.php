<?php

namespace RM\Entity;

use Doctrine\ORM\EntityManager;
use RM\Entity\User;
use RM\Entity\Repository\UserRepository;
use RM\Entity\UsersToRecruitersService;

/**
 * Description of JobListingService
 *
 * @author Csabi
 */
class UserService extends AbstractService
{

    const DEFAULT_PASSWORD = 'd3F4l7@@p4$$W0rd';
    const DEFAULT_SALT = '**un!qu3&&S4l7^^s7r!ng%%';
    const HASH_TYPE = 'sha256';

    public function __construct(EntityManager $em)
    {
        parent::__construct($em);
        $this->entity = $this->getNewUserEntity();
    }

    public function makeUser($email, $type = null)
    {
        $this->entity->setEmail($email);
        $this->entity->setUserStatus(\RM\Entity\User::USER_STATUS_ENABLED_ID);
        $this->entity->setSystemNotifications(\RM\Entity\User::USER_SYSTEM_NOTIFICATIONS_NOT_SPECIFIED);
        $this->entity->setLastIpAddress($_SERVER['REMOTE_ADDR']);
        if(!empty($_SERVER['HTTP_USER_AGENT'])){
            $ua = $_SERVER['HTTP_USER_AGENT'];
        } else{
            $ua = 'CLI';
        }
        $this->entity->setLastUserAgent($ua);

        if ($type !== null) {
            $role = $this->em->getRepository('RM\Entity\Roles')->findOneBy(array('id' => $type));
            $this->entity->setRole($role);
        }

        return $this->entity;
    }

    public function getNewUserEntity()
    {
        return new \RM\Entity\User();
    }

    public function fetchUserId($email, $type)
    {
        $id = null;
        $user = $this->getEntityByEmail($email);
        if ($user instanceof \RM\Entity\User) {
            $id = $user->getId();
        }
        if (null !== $id) {
            return $user;
        } else {
            $userEntity = $this->makeUser($email, $type);
            $id = $this->saveEntity($userEntity);
            $this->generateAndSavePassword($userEntity);

            switch ($type) {
                case \RM\Entity\Roles::RECRUITER:
                    $recruiterService = new \RM\Entity\RecruiterService($this->em);
                    $recruiterEntity = $recruiterService->makeRecruiter(null);
                    $recruiterId = $recruiterService->saveEntity($recruiterEntity);
                    if ($recruiterId) {
                        $usersToRecruitersService = new \RM\Entity\UsersToRecruitersService($this->em);
                        $userToRecruiterEntity = $usersToRecruitersService->makeUserToRecruiterConnection($userEntity, $recruiterEntity);
                        $id = $this->saveEntity($userToRecruiterEntity);
                        if (!$id) {
                            return false;
                        }
                    }
                    break;
                case \RM\Entity\Roles::SEEKER:
                    $jobSeekerService = new \RM\Entity\JobSeekerService($this->em);
                    $jobSeekerEntity = $jobSeekerService->makeJobSeeker($userEntity);
                    $id = $this->saveEntity($jobSeekerEntity);

                    if (!$id) {
                        return false;
                    }
                    break;

                default:
                    break;
            }
            return $userEntity;
        }
    }

    protected function generateAndSavePassword($userEntity)
    {
        $userEntity->setPassword($this->generatePassword($userEntity));
        $this->updateEntity($userEntity);
        return true;
    }

    public function generatePassword($userEntity)
    {
        $password = '';
        $password .= $userEntity->getEmail();
        if ($userEntity->getPassword() != null) {
            $password .= $userEntity->getPassword();
        } else {
            $password .= self::DEFAULT_PASSWORD;
        }
        $password .= $userEntity->getCreatedTime()->format('Y-m-d H:i:s');
        $password .= $userEntity->getSalt();
        $password .= self::DEFAULT_SALT;
        $password .= $userEntity->getId();

        return hash(self::HASH_TYPE, $password);
    }

    public function getEntityByEmail($email)
    {
        $userEntity = $this->em->getRepository('RM\Entity\User')->findOneBy(array(
            'email' => $email));
        return $userEntity;
    }

}
