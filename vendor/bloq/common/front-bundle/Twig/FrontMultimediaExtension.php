<?php

namespace Bloq\Common\FrontBundle\Twig;

class FrontMultimediaExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('primary', array($this, 'primaryImageFilter')),
            new \Twig_SimpleFilter('sizeInfo', array($this, 'imageSizeInfoFilter')),
            new \Twig_SimpleFilter('optimized', array($this, 'optimizedImageFilter'))
        );
    }

    public function primaryImageFilter($multimedias)
    {
        foreach ($multimedias as $multimedia) {
            if ($multimedia->getType() == "image" and $multimedia->getPosition() == "primary") {
                return $multimedia;
            }
        }

        return null;
    }

    public function imageSizeInfoFilter($imagePath)
    {
        $imageSizeInfo = getimagesize($imagePath);

        $imageInfo = array(
            'width' => $imageSizeInfo[0],
            'height' => $imageSizeInfo[1],
            'mime' => $imageSizeInfo['mime'],
        );

        return $imageInfo;
    }

    public function optimizedImageFilter($path, $filter)
    {
        $info = pathinfo($path);

        return $info['dirname'].'/'.$info['filename'].'_'.$filter.'.'.$info['extension'];
    }

    public function getName()
    {
        return 'front_multimedia_extension';
    }
}
