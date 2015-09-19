<?php

namespace Bloq\Common\EditorBundle;

use Bloq\Common\EditorBundle\Entity\Url;

interface EditorialContentInterface
{
    public function addUrl(Url $url);
    public function removeUrl(Url $url);
}

