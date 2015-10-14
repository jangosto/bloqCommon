<?php

namespace Bloq\Common\MultimediaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="multimedia")
 */
class Multimedia
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
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $position;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @Assert\File(mimeTypes={ "image/*" }, mimeTypesMessage="El fichero añadido no es una imagen válida")
     */
    protected $file;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $url;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $title;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $description;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $alt;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $author;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $agency;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @var string
     */
    protected $htmlCode;
    
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
     * Get type.
     *
     * @return type.
     */
    public function getType()
    {
        return $this->type;
    }
    
    /**
     * Set type.
     *
     * @param type the value to set.
     */
    public function setType($type)
    {
        $this->type = $type;
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
     * Get alt.
     *
     * @return alt.
     */
    public function getAlt()
    {
        return $this->alt;
    }
    
    /**
     * Set alt.
     *
     * @param alt the value to set.
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;
    }
    
    /**
     * Get author.
     *
     * @return author.
     */
    public function getAuthor()
    {
        return $this->author;
    }
    
    /**
     * Set author.
     *
     * @param author the value to set.
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }
    
    /**
     * Get agency.
     *
     * @return agency.
     */
    public function getAgency()
    {
        return $this->agency;
    }
    
    /**
     * Set agency.
     *
     * @param agency the value to set.
     */
    public function setAgency($agency)
    {
        $this->agency = $agency;
    }
    
    /**
     * Get file.
     *
     * @return file.
     */
    public function getFile()
    {
        return $this->file;
    }
    
    /**
     * Set file.
     *
     * @param file the value to set.
     */
    public function setFile($file)
    {
        $this->file = $file;
    }
    
    /**
     * Get htmlCode.
     *
     * @return htmlCode.
     */
    public function getHtmlCode()
    {
        return $this->htmlCode;
    }
    
    /**
     * Set htmlCode.
     *
     * @param htmlCode the value to set.
     */
    public function setHtmlCode($htmlCode)
    {
        $this->htmlCode = $htmlCode;
    }
}
