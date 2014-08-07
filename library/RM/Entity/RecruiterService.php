<?php

namespace RM\Entity;

use Doctrine\ORM\EntityManager;
use RM\Entity\Recruiter;

/**
 * Description of RecruiterService
 *
 * @author Csabi
 */
class RecruiterService extends AbstractService
{

    public function __construct(EntityManager $em)
    {
        parent::__construct($em);
        $this->entity = $this->getNewRecruiterEntity();
    }

    public function makeRecruiter($data)
    {
        $this->entity->setRecruiterStatus(Recruiter::RECRUITER_STATUS_ENABLED);
        $this->entity->setPaymentPeriod(Recruiter::PAYMENT_PERIOD_ADHOC_ID);
        if(isset($data['companyName'])){
            $this->entity->setCompanyName($data['companyName']);
        }
        return $this->entity;
    }

    public function getNewRecruiterEntity()
    {
        return new \RM\Entity\Recruiter();
    }
    
}
