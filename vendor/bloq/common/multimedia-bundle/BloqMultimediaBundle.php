<?php

namespace Bloq\Common\MultimediaBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Bloq\Common\MultimediaBundle\Lib\Globals;

class BloqMultimediaBundle extends Bundle
{
    public function boot()
    {
        Globals::setDomainPath($this->container->getParameter('multimedia.domain.path'));
        Globals::setImagesUploadDir($this->container->getParameter('multimedia.images.root_dir.path'));
        Globals::setImagesRelUrl($this->container->getParameter('multimedia.images.root_dir.url'));
    }
}
