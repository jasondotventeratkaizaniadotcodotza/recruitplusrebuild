<?php

/**
 * Description of ListItemsRepository
 *
 * @author Csabi
 */

namespace RM\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class ListRepository extends AbstractRepository
{

    public function getListByShortName($shortName)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->add('select', 'l')
                ->add('from', 'RM\Entity\Lists l')
                ->add('where', 'l.listShortName = ?1')
                ->setParameter(1, $shortName);
        $query = $qb->getQuery();
        $list = $query->getSingleResult();
        return $list;
    }

    public function getListById($id)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->add('select', 'l')
                ->add('from', 'RM\Entity\Lists l')
                ->add('where', 'l.id = ?1')
                ->setParameter(1, $id);
        $query = $qb->getQuery();
        $list = $query->getSingleResult();
        return $list;
    }

    public function getLists()
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->add('select', 'l.id, l.listShortName')
                ->add('from', 'RM\Entity\Lists l');
        $query = $qb->getQuery();
        $lists = $query->getArrayResult();
        return $lists;
    }

}

?>
