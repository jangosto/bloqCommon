<?php

namespace Bloq\Common\EditorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Bloq\Common\EditorBundle\Entity\EditorialContentInterface;


/**
 * @ORM\Entity
 * @ORM\Table(name="url", indexes={@ORM\Index(name="url_idx", columns={"url"})})
 */
class Url
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
    protected $url;

    /**
     * @ORM\Column(type="integer", nullable=false)
     * @var integer
     */
    protected $contentId;

    /**
     * @ORM\Column(type="boolean")
     * @var boolean
     */
    protected $enabled;

    /**
     * @ORM\Column(type="boolean")
     * @var boolean
     */
    protected $canonical;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $contentType;

    
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
     * Get url.
     *
     * @return url.
     */
    public function getUrl()
    {
        return $this->url;
    }
    
    /**
     * Set url.
     *
     * @param url the value to set.
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }
    
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
     * Get canonical.
     *
     * @return canonical.
     */
    public function getCanonical()
    {
        return $this->canonical;
    }
    
    /**
     * Set canonical.
     *
     * @param canonical the value to set.
     */
    public function setCanonical($canonical)
    {
        $this->canonical = $canonical;
    }
    
    /**
     * Get contentType.
     *
     * @return contentType.
     */
    public function getcontentType()
    {
        return $this->contentType;
    }
    
    /**
     * Set contentType.
     *
     * @param contentType the value to set.
     */
    public function setcontentType($contentType)
    {
        $this->contentType = $contentType;
    }
}

