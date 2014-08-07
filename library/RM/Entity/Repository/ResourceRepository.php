<?php

namespace RM\Entity\Repository;

use Doctrine\ORM\Query\ResultSetMappingBuilder;

class ResourceRepository extends AbstractRepository
{

    public function getRoleResources($role)
    {
        $sql = 'SELECT p, rid FROM RM\Entity\Permissions p JOIN p.resourceId rid';

        if (!empty($role)) {
            $sql .= ' WHERE p.roleId = ' . $role->getId();
        }
        $query = $this->_em->createQuery($sql);
        return $query->getArrayResult();
    }

}
