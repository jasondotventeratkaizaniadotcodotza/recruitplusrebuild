<?php

namespace RM\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Table(name="permissions")
 * @ORM\Entity(repositoryClass="RM\Entity\Repository\PermissionsRepository")
 * @author Csabi
 */
class Permissions
{

    const ALLOW = 'allow';
    const DENY = 'deny';

    /**
     * @var integer $id 
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var Roles
     * @ORM\ManyToOne(targetEntity="Roles", cascade={"all"}, fetch="EAGER")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="roleId", referencedColumnName="id",  nullable=false)
     * })
     */
    private $roleId;

    /**
     * @var Resources
     * @ORM\ManyToOne(targetEntity="Resources", cascade={"all"}, fetch="EAGER")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="resourceId", referencedColumnName="id",  nullable=false)
     * })
     */
    private $resourceId;

    /**
     * @var string $permission 
     * @ORM\Column(type="string", nullable=false) 
     */
    private $permission;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getRoleId()
    {
        return $this->roleId;
    }

    public function setRoleId($roleId)
    {
        $this->roleId = $roleId;
    }

    public function getResourceId()
    {
        return $this->resourceId;
    }

    public function setResourceId($resourceId)
    {
        $this->resourceId = $resourceId;
    }

    public function getPermission()
    {
        return $this->permission;
    }

    public function setPermission($permission)
    {
        if (!in_array($permission, array(self::ALLOW, self::DENY))) {
            throw new \InvalidArgumentException("Invalid permission");
        }
        $this->permission = $permission;
    }

}