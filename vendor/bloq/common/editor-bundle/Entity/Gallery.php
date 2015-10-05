<?php

namespace Bloq\Common\EditorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Bloq\Common\EditorBundle\Entity\EditorialContentInterface;
use Bloq\Common\EditorBundle\Entity\EditorialContent;

/**
 * @ORM\Entity
 */
class Gallery extends EditorialContent implements EditorialContentInterface
{
}