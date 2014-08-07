<?php

namespace RM\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Table(name="resources")
 * @ORM\Entity(repositoryClass="RM\Entity\Repository\ResourceRepository")
 * @author Csabi
 */
class Resources
{

    /**
     * @var integer $id 
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\OneToMany(targetEntity="Permissions",mappedBy="resourceId", cascade={"all"})
     */
    private $id;

    /**
     *
     * @var string $resource 
     * @ORM\Column(type="string", nullable=false)
     * 
     */
    private $resource;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getResource()
    {
        return $this->resource;
    }

    public function setResource($resource)
    {
        $this->resource = $resource;
    }

}