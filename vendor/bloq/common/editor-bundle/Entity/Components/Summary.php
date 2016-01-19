<?php

namespace Bloq\Common\EditorBundle\Entity\Components;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="summary")
 */
class Summary
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=true)
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
     * @var string
     */
    protected $text;

    
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
}
