<?php

namespace RM\Entity;

use Doctrine\ORM\EntityManager;
use RM\Entity\Emails;

/**
 * Description of JobListingService
 *
 * @author Csabi
 */
class EmailService extends AbstractService
{

    public function __construct(EntityManager $em)
    {
        parent::__construct($em);
    }

}
