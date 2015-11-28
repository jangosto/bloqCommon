<?php

namespace Bloq\Common\MultimediaBundle\Publisher;

use Bloq\Common\MultimediaBundle\Lib\Globals;

class ImageCropper
{
    protected $cacheManager;
    protected $dataManager;
    protected $filterManager;
    protected $image;
    protected $cachePrefix;

    public function __construct($cacheManager, $dataManager, $filterManager, $cachePrefix)
    {
        $this->cacheManager = $cacheManager;
        $this->dataManager = $dataManager;
        $this->filterManager = $filterManager;
        $this->cachePrefix = $cachePrefix;
    }

    public function generateImageCrops($filters)
    {
        $filtersArray = $this->filterManager->getFilterConfiguration()->all();
        foreach ($filters as $filter) {
            if (isset($filtersArray[$filter])) {
                $destinationPath = $this->cropImage($filter);
                $cachedImagePath = Globals::getDomainPath()."/".$this->cachePrefix."/".$filter.Globals::getOriginalImagesUploadDir().$this->image->getPath();

                $imageDestinationPath = Globals::getDomainPath().$this->image->getImagesUploadDir().$destinationPath;
                $imageDestinationPathInfo = pathinfo($imageDestinationPath);

                if (!file_exists($imageDestinationPathInfo['dirname']) or !is_dir($imageDestinationPathInfo['dirname'])) {
                    mkdir($imageDestinationPathInfo['dirname'], 0755, true);
                }
                copy($cachedImagePath, $imageDestinationPath);
            }
        }
    }

    private function cropImage($filter)
    {
        $path = $this->image->getOriginalImagesUploadDir().$this->image->getPath();

        $image = $this->dataManager->find($filter, $path);
        $filteredBinary = $this->filterManager->applyFilter($image, $filter);
        $this->cacheManager->store($filteredBinary, $path, $filter);

        $imageInfo = pathinfo($path);
        $croppedImagePath = str_replace($imageInfo['filename'], $imageInfo['filename']."_".$filter, $this->image->getPath());

        return $croppedImagePath;
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
}
