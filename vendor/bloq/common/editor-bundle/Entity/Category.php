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
     * @ORM\OneToMany(targetEntity="Bloq\Common\EditorBundle\Entity\EditorialContent", mappedBy="category")
     * @ORM\JoinColumn(name="content_id", referencedColumnName="id")
     */
    protected $contents;


    public function __construct()
    {
        $this->contents = new ArrayCollection();
    }

    /**
     * Add Content
     *
     * @param content
     */
    public function addContent(EditorialContentInterface $content)
    {
        $content->setCategory($this);
        $this->contents[] = $content;

        return $this;
    }

    /**
     * Remove Content
     *
     * @param content
     */
    public function removeContent(EditorialContentInterface $content)
    {
        $this->contents->remove($content);
        $content->setCategory(null);

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
}
