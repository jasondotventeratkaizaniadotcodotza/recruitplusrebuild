<?php

namespace RM\Entity;

use Doctrine\ORM\EntityManager;
use RM\Entity\JobApplication;

/**
 * Description of ApplicationRatingsService
 *
 * @author Csabi
 */
class ApplicationRatingsService extends AbstractService
{

    public function __construct(EntityManager $em)
    {
        parent::__construct($em);
        $this->entity = $this->createApplicationRating();
    }

    public function makeApplicationRating($data)
    {
        $this->entity->setJobApplicationId($data['jobApplicationId']);
        $this->entity->setUserId($data['userId']);
        if(isset($data['userRating'])) $this->entity->setUserRating ($data['userRating']);
        if(isset($data['userComment'])) $this->entity->setUserRating ($data['userComment']);
        
        return $this->entity;
    }

    public function createApplicationRating()
    {
        return new \RM\Entity\ApplicationRatings();
    }

}
