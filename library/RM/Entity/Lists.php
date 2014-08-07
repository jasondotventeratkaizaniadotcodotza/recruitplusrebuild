<?php

namespace RM\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Description of Lists
 * @ORM\Entity(repositoryClass="RM\Entity\Repository\ListRepository")
 * @ORM\Table(name="lists",uniqueConstraints={@ORM\UniqueConstraint(name="list_shortname", columns={"listShortName"})})
 * @author Csabi
 */
class Lists
{

    /**
     * @var integer $id 
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\OneToMany(targetEntity="ListItems",mappedBy="lists", cascade={"all"})
     * @param \Doctrine\Common\Collections\Collection $property
     */
    private $id;

    /**
     * @var string $listShortName
     * @ORM\Column(type="string", nullable=false)
     */
    private $listShortName;

    /**
     * @var string $listName
     * @ORM\Column(type="string", nullable=false)
     */
    private $listName;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getListShortName()
    {
        return $this->listShortName;
    }

    public function setListShortName($listShortName)
    {
        $this->listShortName = $listShortName;
    }

    public function getListName()
    {
        return $this->listName;
    }

    public function setListName($listName)
    {
        $this->listName = $listName;
    }

}