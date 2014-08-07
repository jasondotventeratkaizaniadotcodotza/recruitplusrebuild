<?php

namespace RM\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Table(name="roles")
 * @ORM\Entity(repositoryClass="RM\Entity\Repository\RolesRepository")
 * @author Csabi
 */
class Roles
{

    const GUEST = 1;
    const GUEST_NAME = 'guest';
    const ADMINISTRATOR = 2;
    const ADMINISTRATOR_NAME = 'administrator';
    const SUPERAMINISTRATOR = 3;
    const SUPERAMINISTRATOR_NAME = 'superadministrator';
    const SEEKER = 4;
    const SEEKER_NAME = 'seeker';
    const RECRUITER = 5;
    const RECRUITER_NAME = 'recruiter';
    const PREMIUM_RECRUITER = 6;
    const PREMIUM_RECRUITER_NAME = 'premium recruiter';

    /**
     * @var integer $id 
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\OneToMany(targetEntity="Permissions",mappedBy="roleId", cascade={"all"})
     * @ORM\OneToMany(targetEntity="User",mappedBy="role", cascade={"all"})
     */
    private $id;

    /**
     *
     * @var string $resource 
     * @ORM\Column(type="string", nullable=false)
     * 
     */
    private $role;

    /**
     * @var integer $parentId; 
     * @ORM\Column(type="integer", nullable=false)
     */
    private $parentId;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role)
    {
        $this->role = $role;
    }

    public function getParentId()
    {
        return $this->parentId;
    }

    public function setParentId($parentId)
    {
        $this->parentId = $parentId;
    }

}