<?php

namespace Bloq\Common\MultimediaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Bloq\Common\MultimediaBundle\Lib\Globals;

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
     * @Assert\File(mimeTypes={ "image/*" }, mimeTypesMessage="El fichero añadido no es una imagen válida", maxSize="1M", maxSizeMessage="El fichero añadido es demasiado grande (tamaño máximo: 1M)")
     */
    protected $file;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $image;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $originalImage;
    
    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $path;

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

    public function getOriginalImagesRootDir()
    {
        return Globals::getDomainPath().$this->getOriginalImagesUploadDir();
    }

    public function getImagesUploadRootDir()
    {
        return Globals::getDomainPath().$this->getImagesUploadDir();
    }

    public function getOriginalImagesUploadDir()
    {
        return Globals::getOriginalImagesUploadDir();
    }

    public function getImagesUploadDir()
    {
        return Globals::getImagesUploadDir();
    }

    public function getImagesUploadDirUrl()
    {
        return Globals::getImagesRelUrl();
    }

    public function getImageAbsolutePath()
    {
        return null === $this->path ? null : $this->getImagesUploadRootDir().'/'.$this->path;
    }

    public function getImageWebPath()
    {
        return null === $this->path ? null : Globals::getImagesRelUrl().$this->path;
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
     * Get path.
     *
     * @return path.
     */
    public function getPath()
    {
        return $this->path;
    }
    
    /**
     * Set path.
     *
     * @param path the value to set.
     */
    public function setPath($path)
    {
        $this->path = $path;
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
    
    /**
     * Get position.
     *
     * @return position.
     */
    public function getPosition()
    {
        return $this->position;
    }
    
    /**
     * Set position.
     *
     * @param position the value to set.
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }
    
    /**
     * Get originalImage.
     *
     * @return originalImage.
     */
    public function getOriginalImage()
    {
        return $this->originalImage;
    }
    
    /**
     * Set originalImage.
     *
     * @param originalImage the value to set.
     */
    public function setOriginalImage($originalImage)
    {
        $this->originalImage = $originalImage;
    }

    public function isOriginalImage($image)
    {
        $response = false;
        if ($image === $this->originalImage) {
            $response = true;
        }

        return $response;
    }

    public function hasOriginalImage()
    {
        $response = false;
        if (strlen($this->originalImage) > 0) {
            $response = true;
        }

        return $response;
    }
    
    /**
     * Get image.
     *
     * @return image.
     */
    public function getImage()
    {
        return $this->image;
    }
    
    /**
     * Set image.
     *
     * @param image the value to set.
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    public function isImage()
    {
        return true;
    }

    public function hasImage()
    {
        $response = false;
        if (strlen($this->image) > 0) {
            $response = true;
        }

        return $response;
    }
}
