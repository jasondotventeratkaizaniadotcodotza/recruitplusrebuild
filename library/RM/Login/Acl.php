<?php

namespace RM\Login;

/**
 * Acl
 *
 * @author Enrico Zimuel (enrico@zimuel.it)
 */
class Acl extends \Zend_Acl
{

    /**
     * __construct
     *
     * @param Zend_Db_Adapter $db
     * @param integer $role
     */
    public $inhRole;

    public function __construct($em, $userEntity)
    {
        $this->loadRoles($em);
        $this->inhRole = $userEntity->getRole();
        while (!empty($this->inhRole)) {
            $this->loadResources($em, $this->inhRole);
            $this->loadPermissions($em, $this->inhRole);
            $this->inhRole = $em->getRepository('RM\Entity\Roles')->findOneBy(array('id' => $this->inhRole->getParentId()));
        }
    }

    /**
     * Load all the roles from the DB
     *
     * @param Zend_Db_Adapter $db
     * @return boolean
     */
    public function loadRoles($em)
    {
        if (empty($em)) {
            return false;
        }
        $roles = $em->getRepository('RM\Entity\Roles')->findBy(array());
        foreach ($roles as $role) {
            $this->addRole(new \Zend_Acl_Role($role->getRole()));
        }
        return true;
    }

    /**
     * Load all the resources for the specified role
     *
     * @param Entity_Manager $em
     * @param RM\Entity\Role $userRole
     * @return boolean
     */
    public function loadResources($em, $userRole)
    {
        if (empty($em)) {
            return false;
        }
        $roleResources = $em->getRepository('RM\Entity\Resources')->getRoleResources($userRole);
        foreach ($roleResources as $res) {
            $res = $res['resourceId']['resource'];
            if (!$this->has($res)) {
                $this->addResource(new \Zend_Acl_Resource($res));
            }
        }
        return true;
    }

    /**
     * Load all the permission for the specified role
     *
     * @param Entity_Manager $em
     * @param RM\Entity\Role $userRole
     * @return boolean
     */
    public function loadPermissions($em, $userRole)
    {
        if (empty($em)) {
            return false;
        }
        $allPermissions = $em->getRepository('RM\Entity\Permissions')->getRolePermissions($userRole);

        foreach ($allPermissions as $res) {
            if ($res['permission'] == 'allow') {
                $this->allow($res['roleId']['role'], $res['resourceId']['resource']);
            } else {
                $this->deny($res['roleId']['role'], $res['resourceId']['resource']);
            }
        }
        return true;
    }

}
