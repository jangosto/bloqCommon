<?php

namespace Bloq\Common\FrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Bloq\Common\EditorBundle\Entity\EditorialContentInterface;
use Bloq\Common\EditorBundle\Entity\Article as BloqEditorArticle;

/**
 * @ORM\Entity
 */
class Article extends BloqEditorArticle implements EditorialContentInterface
{
}
