<?php

namespace RM\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class JobListingRepository extends AbstractRepository
{

    public function getJobListing($id)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->add('select', 'j')
                ->add('from', 'RM\Entity\JobListing j')
                ->add('where', 'j.id = ?1')
                ->setParameter(1, $id);
        $query = $qb->getQuery();
        $jobListingModel = $query->getSingleResult();
        return $jobListingModel;
    }

    public function getAllJobListings()
    {
        $query = $this->_em->createQuery('SELECT j FROM RM\Entity\JobListing j');
        $jobListings = $query->getArrayResult();

        return $jobListings;
    }

    public function getRecruiterJobListings($user)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->add('select', 'j')
                ->add('from', 'RM\Entity\JobListing j')
                ->add('where', 'j.userId = ?1')
                ->setParameter(1, $user->getId());
        $query = $qb->getQuery();
        $jobListings = $query->getArrayResult();
        return $jobListings;
    }

}