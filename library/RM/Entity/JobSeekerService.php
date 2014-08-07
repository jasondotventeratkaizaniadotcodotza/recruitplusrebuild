<?php

namespace RM\Entity;

use Doctrine\ORM\EntityManager;
use RM\Entity\JobSeeker;

/**
 * Description of RecruiterService
 *
 * @author Csabi
 */
class JobSeekerService extends AbstractService
{

    public function __construct(EntityManager $em)
    {
        parent::__construct($em);
        $this->entity = $this->getNewJobSeekerEntity();
    }

    public function makeJobSeeker($user)
    {
        $this->entity->setUserId($user);
        return $this->entity;
    }

    public function getNewJobSeekerEntity()
    {
        return new \RM\Entity\JobSeeker();
    }

}
