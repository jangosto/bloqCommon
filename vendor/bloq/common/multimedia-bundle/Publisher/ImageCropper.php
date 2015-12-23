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

    public function generateImageVersions($multimedia, $versions)
    {
        foreach ($multimedia->getCrops() as $filter => $crop) {
            if (in_array($filter, $versions)) {
                $jsonArray = json_decode($crop);
                $config = array(
                    'filters' => array(
                        'crop' => array(
                            'start' => array($jsonArray->x, $jsonArray->y),
                            'size' => array($jsonArray->width, $jsonArray->height)
                        )
                    )
                );
                $path = $multimedia->getOriginalImagesUploadDir().$multimedia->getPath();
                $pathInfo = pathinfo($path);
                $destinationPath = $this->cropImage($path, $filter, $config);
                $destinationPathInfo = pathinfo($destinationPath);
                $cachedImagePath = Globals::getDomainPath()."/".$this->cachePrefix."/".$filter.Globals::getOriginalImagesUploadDir().$this->image->getPath();
                $imageDestinationPath = Globals::getDomainPath().$pathInfo['dirname']."/".$destinationPathInfo['basename'];
                copy($cachedImagePath, $imageDestinationPath);
            }
        }
    }

    public function generateImageCrops($filters)
    {
        $filtersArray = $this->filterManager->getFilterConfiguration()->all();
        foreach ($filters as $filter) {
            if (isset($filtersArray[$filter])) {
                $crops = array_keys($this->image->getCrops());
                $crops[] = "";
                foreach ($crops as $cropName) {
                    $path = $this->image->getOriginalImagesUploadDir().$this->image->getPath();
                    if ($cropName !== "") {
                        $pathInfo = pathinfo($path);
                        $path = $pathInfo['dirname']."/".$pathInfo['filename']."_".$cropName.".".$pathInfo['extension'];
                    }
                    $destinationPath = $this->cropImage($path, $filter);
                    $imageInfo = pathinfo($path);
                    $baseImagePath = $this->image->getPath();
                    $baseImagePathInfo = pathinfo($baseImagePath);
                    $cachedImagePath = Globals::getDomainPath()."/".$this->cachePrefix."/".$filter.Globals::getOriginalImagesUploadDir().$baseImagePathInfo['dirname']."/".$imageInfo['basename'];

                    $imageDestinationPath = Globals::getDomainPath().$this->image->getImagesUploadDir().$destinationPath;
                    $imageDestinationPathInfo = pathinfo($imageDestinationPath);

                    if (!file_exists($imageDestinationPathInfo['dirname']) or !is_dir($imageDestinationPathInfo['dirname'])) {
                        mkdir($imageDestinationPathInfo['dirname'], 0755, true);
                    }
                    copy($cachedImagePath, $imageDestinationPath);
                }
            }
        }
    }

    private function cropImage($path, $filter, $config = null)
    {
        $image = $this->dataManager->find($filter, $path);
        if ($config == null) {
            $filteredBinary = $this->filterManager->applyFilter($image, $filter);
        } else {
            $filteredBinary = $this->filterManager->applyFilter($image, $filter, $config);
        }
        $this->cacheManager->store($filteredBinary, $path, $filter);

        $imageInfo = pathinfo($path);
        $baseImagePath = $this->image->getPath();
        $baseImagePathInfo = pathinfo($baseImagePath);
        $croppedImagePath = $baseImagePathInfo['dirname']."/".$imageInfo['filename']."_".$filter.".".$imageInfo['extension'];

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
