<?php

namespace Bloq\Common\MultimediaBundle\Lib;

class Globals
{
    protected static $domainPath;
    protected static $imagesUploadDir;
    protected static $originalImagesUploadDir;
    protected static $imagesRelUrl;


    /**
     * Get domainPath.
     *
     * @return domainPath.
     */
    public static function getDomainPath()
    {
        return self::$domainPath;
    }
    
    /**
     * Set domainPath.
     *
     * @param domainPath the value to set.
     */
    public static function setDomainPath($domainPath)
    {
        self::$domainPath = $domainPath;
    }
    
    /**
     * Get imagesUploadDir.
     *
     * @return imagesUploadDir.
     */
    public static function getImagesUploadDir()
    {
        return self::$imagesUploadDir;
    }
    
    /**
     * Set imagesUploadDir.
     *
     * @param imagesUploadDir the value to set.
     */
    public static function setImagesUploadDir($imagesUploadDir)
    {
        self::$imagesUploadDir = $imagesUploadDir;
    }
    
    /**
     * Get imagesRelUrl.
     *
     * @return imagesRelUrl.
     */
    public static function getImagesRelUrl()
    {
        return self::$imagesRelUrl;
    }
    
    /**
     * Set imagesRelUrl.
     *
     * @param imagesRelUrl the value to set.
     */
    public static function setImagesRelUrl($imagesRelUrl)
    {
        self::$imagesRelUrl = $imagesRelUrl;
    }
    
    /**
     * Get originalImagesUploadDir.
     *
     * @return originalImagesUploadDir.
     */
    public static function getOriginalImagesUploadDir()
    {
        return self::$originalImagesUploadDir;
    }
    
    /**
     * Set originalImagesUploadDir.
     *
     * @param originalImagesUploadDir the value to set.
     */
    public static function setOriginalImagesUploadDir($originalImagesUploadDir)
    {
        self::$originalImagesUploadDir = $originalImagesUploadDir;
    }
}
