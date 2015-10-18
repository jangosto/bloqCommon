<?php

namespace Bloq\Common\EditorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Bloq\Common\EditorBundle\Entity\EditorialContentInterface;


/**
 * @ORM\Entity
 * @ORM\Table(name="url")
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
     * @ORM\ManyToOne(targetEntity="Bloq\Common\EditorBundle\Entity\EditorialContentInterface", inversedBy="urls")
     * @ORM\JoinColumn(name="content_id", referencedColumnName="id")
     */
    protected $content;

    /**
     * @ORM\Column(type="boolean")
     * @var boolean
     */
    protected $enabled;

    /**
     * @ORM\Column(type="boolean")
     * @var boolean
     */
    protected $primary;

    
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
     * Get content.
     *
     * @return content.
     */
    public function getContent()
    {
        return $this->content;
    }
    
    /**
     * Set content.
     *
     * @param content the value to set.
     */
    public function setContent($content)
    {
        $this->content = $content;
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
     * Get primary.
     *
     * @return primary.
     */
    public function getPrimary()
    {
        return $this->primary;
    }
    
    /**
     * Set primary.
     *
     * @param primary the value to set.
     */
    public function setPrimary($primary)
    {
        $this->primary = $primary;
    }
}

