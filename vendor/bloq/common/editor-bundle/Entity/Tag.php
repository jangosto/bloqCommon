<?php

namespace Bloq\Common\EditorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * @ORM\Entity
 * @ORM\Table(name="tag")
 */
class Tag
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $name;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $slug;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @var string
     */
    protected $description;

     /**
      * @ORM\Column(type="integer", nullable=true)
      * @var int
      */
     private $parentId;

    /**
     * @ORM\ManyToMany(targetEntity="Bloq\Common\EditorBundle\Entity\EditorialContentInterface", mappedBy="tags")
     */
    protected $contents;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @var bool
     */
    protected $enabled;


    public function __construct() {
        $this->contents = new ArrayCollection();
    }

    /**
     * Get id.
     *
     * @return id.
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Set id.
     *
     * @param id the value to set.
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    
    /**
     * Get name.
     *
     * @return name.
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Set name.
     *
     * @param name the value to set.
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    
    /**
     * Get slug.
     *
     * @return slug.
     */
    public function getSlug()
    {
        return $this->slug;
    }
    
    /**
     * Set slug.
     *
     * @param slug the value to set.
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }
    
    /**
     * Get contents.
     *
     * @return contents.
     */
    public function getContents()
    {
        return $this->contents;
    }
    
    /**
     * Set contents.
     *
     * @param contents the value to set.
     */
    public function setContents($contents)
    {
        $this->contents = $contents;
    }
    
    /**
     * Get description.
     *
     * @return description.
     */
    public function getDescription()
    {
        return $this->description;
    }
    
    /**
     * Set description.
     *
     * @param description the value to set.
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }
    
    /**
     * Get children.
     *
     * @return children.
     */
    public function getChildren()
    {
        return $this->children;
    }
    
    /**
     * Set children.
     *
     * @param children the value to set.
     */
    public function setChildren($children)
    {
        $this->children = $children;
    }
    
    /**
     * Get parentId.
     *
     * @return parentId.
     */
    public function getParentId()
    {
        return $this->parentId;
    }
    
    /**
     * Set parentId.
     *
     * @param parentId the value to set.
     */
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;
    }
    
    /**
     * Get enabled.
     *
     * @return enabled.
     */
    public function getEnabled()
    {
        return $this->enabled;
    }
    
    /**
     * Set enabled.
     *
     * @param enabled the value to set.
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }
}
