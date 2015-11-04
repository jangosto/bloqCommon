<?php

namespace Bloq\Common\EditorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="contents_categories")
 */
class ContentsCategories
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="integer")
     */
    protected $contentId;

    /**
     * @ORM\Column(type="integer")
     */
    protected $categoryId;
    
    /**
     * Get contentId.
     *
     * @return contentId.
     */
    public function getContentId()
    {
        return $this->contentId;
    }
    
    /**
     * Set contentId.
     *
     * @param contentId the value to set.
     */
    public function setContentId($contentId)
    {
        $this->contentId = $contentId;
    }
    
    /**
     * Get categoryId.
     *
     * @return categoryId.
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }
    
    /**
     * Set categoryId.
     *
     * @param categoryId the value to set.
     */
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;
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
}
