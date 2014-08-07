<?php

namespace RM\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Description of ListItems
 * @ORM\Table(name="list_items",uniqueConstraints={@ORM\UniqueConstraint(name="list_item", columns={"listId", "itemId"})})
 * @ORM\Entity(repositoryClass="RM\Entity\Repository\ListItemsRepository")
 * @author Csabi
 */
class ListItems
{

    /**
     * @var integer $id 
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\OneToMany(targetEntity="JobListing", cascade={"all"})
     */
    private $id;

    /**
     *
     * @var Lists
     * @ORM\ManyToOne(targetEntity="Lists", cascade={"all"}, fetch="EAGER")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="listId", referencedColumnName="id",  nullable=false)
     * })
     */
    private $listId;

    /**
     * @var integer $itemId
     * @ORM\Column(type="integer", nullable=false)
     */
    private $itemId;

    /**
     * @var integer $name
     * @ORM\Column(type="string", nullable=false)
     */
    private $name;

    /**
     *
     * @var integer $defaultValue 
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $defaultValue;

    /**
     * @var integer $displayOrder
     * @ORM\Column(type="integer", nullable=false)
     */
    private $displayOrder;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getListId()
    {
        return $this->listId;
    }

    public function setListId($listId)
    {
        $this->listId = $listId;
    }

    public function getItemId()
    {
        return $this->itemId;
    }

    public function setItemId($itemId)
    {
        $this->itemId = $itemId;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getDefaultValue()
    {
        return $this->defaultValue;
    }

    public function setDefaultValue($defaultValue)
    {
        $this->defaultValue = $defaultValue;
    }

    public function getDisplayOrder()
    {
        return $this->displayOrder;
    }

    public function setDisplayOrder($displayOrder)
    {
        $this->displayOrder = $displayOrder;
    }

    public function __toString()
    {
        return strval($this->id);
    }

}