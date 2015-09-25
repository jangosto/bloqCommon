<?php

namespace Bloq\Common\EditorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Bloq\Common\EditorBundle\Entity\Url;
use Bloq\Common\EditorBundle\Entity\EditorialContentInterface;

class EditorialContent implements EditorialContentInterface
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
    protected $type;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $pretitle;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $title;

    /**
     * @ORM\Column(type="string", unique=true)
     * @var string
     */
    protected $subtitle;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $text;

    /**
     * @ORM\Column(type="array")
     */
    protected $authors;

    /**
     * @ORM\OneToMany(targetEntity="Url", mappedBy="content")
     * @ORM\JoinColumn(name="url_id", referencedColumnName="id")
     */
    protected $urls;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $status;

    /**
     * @ORM\Column(type="datetime")
     * @var datetime
     */
    protected $createdDT;

    /**
     * @ORM\Column(type="datetime")
     * @var datetime
     */
    protected $publishedDT;

    /**
     * @ORM\Column(type="datetime")
     * @var datetime
     */
    protected $updatedDT;


    public function __construct()
    {
        $this->authors = array();
        $this->urls = new ArrayCollection();
    }

    /**
     * Add author
     *
     * @param author id (external database)
     */
    public function addAuthor($author)
    {
        if (!in_array($author, $this->authors, true)) {
            $this->authors[] = $author;
        }

        return $this;
    }

    /**
     * Remove author
     *
     * @param author id (external database)
     */
    public function removeAuthor($author)
    {
        if (false !== $key = array_search($author, $this->authors, true)) {
            unset($this->authors[$key]);
            $this->authors = array_values($this->authors);
        }

        return $this;
    }

    /**
     * Add url
     *
     * @param Url url
     */
    public function addUrl(Url $url)
    {
        $url->setContent($this);
        $this->urls[] = $url;
    }

    /**
     * Remove url
     *
     * @param Url url
     */
    public function removeUrl(Url $url)
    {
        $this->urls->remove($url);
        $url->setContent(null);
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
     * Get pretitle.
     *
     * @return pretitle.
     */
    public function getPretitle()
    {
        return $this->pretitle;
    }
    
    /**
     * Set pretitle.
     *
     * @param pretitle the value to set.
     */
    public function setPretitle($pretitle)
    {
        $this->pretitle = $pretitle;
    }
    
    /**
     * Get title.
     *
     * @return title.
     */
    public function getTitle()
    {
        return $this->title;
    }
    
    /**
     * Set title.
     *
     * @param title the value to set.
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }
    
    /**
     * Get subtitle.
     *
     * @return subtitle.
     */
    public function getSubtitle()
    {
        return $this->subtitle;
    }
    
    /**
     * Set subtitle.
     *
     * @param subtitle the value to set.
     */
    public function setSubtitle($subtitle)
    {
        $this->subtitle = $subtitle;
    }
    
    /**
     * Get text.
     *
     * @return text.
     */
    public function getText()
    {
        return $this->text;
    }
    
    /**
     * Set text.
     *
     * @param text the value to set.
     */
    public function setText($text)
    {
        $this->text = $text;
    }
    
    /**
     * Get authors.
     *
     * @return authors.
     */
    public function getAuthors()
    {
        return $this->authors;
    }
    
    /**
     * Set authors.
     *
     * @param authors the value to set.
     */
    public function setAuthors($authors)
    {
        $this->authors = $authors;
    }
    
    /**
     * Get urls.
     *
     * @return urls.
     */
    public function getUrls()
    {
        return $this->urls;
    }
    
    /**
     * Set urls.
     *
     * @param urls the value to set.
     */
    public function setUrls($urls)
    {
        $this->urls = $urls;
    }
    
    /**
     * Get status.
     *
     * @return status.
     */
    public function getStatus()
    {
        return $this->status;
    }
    
    /**
     * Set status.
     *
     * @param status the value to set.
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }
    
    /**
     * Get createdDT.
     *
     * @return createdDT.
     */
    public function getCreatedDT()
    {
        return $this->createdDT;
    }
    
    /**
     * Set createdDT.
     *
     * @param createdDT the value to set.
     */
    public function setCreatedDT($createdDT)
    {
        $this->createdDT = $createdDT;
    }
    
    /**
     * Get publishedDT.
     *
     * @return publishedDT.
     */
    public function getPublishedDT()
    {
        return $this->publishedDT;
    }
    
    /**
     * Set publishedDT.
     *
     * @param publishedDT the value to set.
     */
    public function setPublishedDT($publishedDT)
    {
        $this->publishedDT = $publishedDT;
    }
    
    /**
     * Get updatedDT.
     *
     * @return updatedDT.
     */
    public function getUpdatedDT()
    {
        return $this->updatedDT;
    }
    
    /**
     * Set updatedDT.
     *
     * @param updatedDT the value to set.
     */
    public function setUpdatedDT($updatedDT)
    {
        $this->updatedDT = $updatedDT;
    }
}

