<?php

namespace RM\Entity\Repository;

class GeolocationRepository extends AbstractRepository
{

    public function getAllPostalCodes()
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->add('select', 'p')
                ->add('from', 'RM\Entity\Geolocation p')
                ->add('orderBy', 'p.postalCode');
        $query = $qb->getQuery();
        $postalCodes = array();
        
        $result = $query->getResult();
        foreach ($result as $value) {
            $postalCodes[] = $value->getLocation();
        }
        return $postalCodes;
    }
    
}
