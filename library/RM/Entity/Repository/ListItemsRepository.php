<?php

/**
 * Description of ListItemsRepository
 *
 * @author User
 */

namespace RM\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class ListItemsRepository extends AbstractRepository
{

    public function getListItemsByListId($listId)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->add('select', 'l')
                ->add('from', 'RM\Entity\ListItems l')
                ->add('where', 'l.listId = ?1')
                ->add('orderBy', 'l.displayOrder')
                ->addOrderBy('l.name')
                ->setParameter(1, $listId);
        $query = $qb->getQuery();
        $list = $query->getArrayResult();
        return $list;
    }

    public function getListItemById($id)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->add('select', 'l')
                ->add('from', 'RM\Entity\ListItems l')
                ->add('where', 'l.id = ?1')
                ->setParameter(1, $id);
        $query = $qb->getQuery();
        $listItem = $query->getSingleResult();
        return $listItem;
    }

    public function getListItemByListIdAndItemId($listId, $itemId)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->add('select', 'l')
                ->add('from', 'RM\Entity\ListItems l')
                ->add('where', 'l.listId = ?1')
                ->andWhere('l.itemId = ?2')
                ->setParameters(array(1 => $listId, 2 => $itemId))
                ->setMaxResults(1);

        $query = $qb->getQuery();
        $listItem = $query->getSingleResult();
        return $listItem;
    }

    public function getDefaultListItem($listId)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->add('select', 'l')
                ->add('from', 'RM\Entity\ListItems l')
                ->add('where', 'l.listId = ?1')
                ->andWhere('l.defaultValue = ?2')
                ->setParameters(array(1 => $listId, 2 => 1))
                ->setMaxResults(1);

        $query = $qb->getQuery();
        $listItem = $query->getSingleResult();
        return $listItem;
    }

}