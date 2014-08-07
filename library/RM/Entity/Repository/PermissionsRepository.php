<?php

namespace RM\Entity\Repository;

class PermissionsRepository extends AbstractRepository
{
    
    public function getRolePermissions($role)
    {
        $sql = 'SELECT p, res, roles FROM RM\Entity\Permissions p JOIN p.resourceId res JOIN p.roleId roles';

        if (!empty($role)) {
            $sql .= ' WHERE p.roleId = ' . $role->getId();
        }
        $query = $this->_em->createQuery($sql);
        return $query->getArrayResult();
    }

}
