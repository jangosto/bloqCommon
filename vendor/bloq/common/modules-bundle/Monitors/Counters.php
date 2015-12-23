<?php

namespace Bloq\Common\ModulesBundle\Monitors;

use Doctrine\Common\Collections\ArrayCollection;

class Counters
{
    protected $usedContents;
    protected $outstandingSections;

    public function __construct($outstandingSections = array())
    {
        $this->usedContents = new ArrayCollection();
        $this->outstandingSections = new ArrayCollection($outstandingSections);
    }
    
    /**
     * Get usedContents.
     *
     * @return usedContents.
     */
    public function getUsedContents()
    {
        return $this->usedContents;
    }
    
    /**
     * Set usedContents.
     *
     * @param usedContents the value to set.
     */
    public function setUsedContents($usedContents)
    {
        $this->usedContents = $usedContents;
    }
    
    /**
     * Get outstandingSections.
     *
     * @return outstandingSections.
     */
    public function getOutstandingSections()
    {
        return $this->outstandingSections;
    }
    
    /**
     * Set outstandingSections.
     *
     * @param outstandingSections the value to set.
     */
    public function setOutstandingSections($outstandingSections)
    {
        $this->outstandingSections = $outstandingSections;
    }
}
