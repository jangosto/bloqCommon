<?php

namespace Bloq\Common\MultimediaBundle\Lib;

class Globals
{
    protected static $domainPath;
    protected static $imagesUploadDir;
    protected static $imagesRelUrl;


    /**
     * Get domainPath.
     *
     * @return domainPath.
     */
    public function getDomainPath()
    {
        return self::$domainPath;
    }
    
    /**
     * Set domainPath.
     *
     * @param domainPath the value to set.
     */
    public function setDomainPath($domainPath)
    {
        self::$domainPath = $domainPath;
    }
    
    /**
     * Get imagesUploadDir.
     *
     * @return imagesUploadDir.
     */
    public function getImagesUploadDir()
    {
        return self::$imagesUploadDir;
    }
    
    /**
     * Set imagesUploadDir.
     *
     * @param imagesUploadDir the value to set.
     */
    public function setImagesUploadDir($imagesUploadDir)
    {
        self::$imagesUploadDir = $imagesUploadDir;
    }
    
    /**
     * Get imagesRelUrl.
     *
     * @return imagesRelUrl.
     */
    public function getImagesRelUrl()
    {
        return self::$imagesRelUrl;
    }
    
    /**
     * Set imagesRelUrl.
     *
     * @param imagesRelUrl the value to set.
     */
    public function setImagesRelUrl($imagesRelUrl)
    {
        self::$imagesRelUrl = $imagesRelUrl;
    }
}
