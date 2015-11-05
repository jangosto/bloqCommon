<?php

namespace Bloq\Common\EditorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="contents_tags")
 */
class ContentsTags
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
    protected $tagId;
    
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
     * Get tagId.
     *
     * @return tagId.
     */
    public function getTagId()
    {
        return $this->tagId;
    }
    
    /**
     * Set tagId.
     *
     * @param tagId the value to set.
     */
    public function setTagId($tagId)
    {
        $this->tagId = $tagId;
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
