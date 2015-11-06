<?php

namespace Bloq\Common\EditorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Bloq\Common\EditorBundle\Entity\EditorialContentInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="category")
 */
class Category
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
     * @ORM\Column(type="boolean", nullable=true)
     * @var bool
     */
    protected $enabled;

    /**
     * @var array
     */
    protected $children;

    /**
     * @var array
     */
    protected $contentIds;


    public function __construct()
    {
        $this->contentIds = array();
    }

    public function addContentId($contentiId)
    {
        $this->contentIds[] = $contentId;

        return $this;
    }

    public function removeContentId($contentId)
    {
        if ($key = array_search($contentId, $this->contentIds) !== false) {
            unset($this->contentIds[$key]);
            $this->contentIds = array_values($this->contentIds);
        }

        return $this;
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
     * Get contentIds.
     *
     * @return contentIds.
     */
    public function getContentIds()
    {
        return $this->contentIds;
    }
    
    /**
     * Set contentIds.
     *
     * @param contentIds the value to set.
     */
    public function setContentIds($contentIds)
    {
        $this->contentIds = $contentIds;
    }
}
