<?php

namespace Bloq\Common\EditorBundle\Manager;

class ContentsCategoriesManager
{
    const DOCTRINE_ENTITY_MANAGER_CLASS = "Doctrine\\ORM\\EntityManager";
    const DOCTRINE_SERVICE_CLASS = "Doctrine\\Bundle\\DoctrineBundle\\Registry";

    protected $em;
    protected $repository;
    protected $class;

    public function __construct($doctrine, $class)
    {
        $doctrineServiceClass = self::DOCTRINE_SERVICE_CLASS;
        $doctrineEntityManager = self::DOCTRINE_ENTITY_MANAGER_CLASS;

        if ($doctrine instanceof $doctrineEntityManager) {
            $this->em = $doctrine;
        } elseif ($doctrine instanceof $doctrineServiceClass) {
            $this->em = $doctrine->getManager('content');
        }
        $this->class = $class;
        $this->repository = $this->em->getRepository($this->class);
    }

    public function saveRelationships($content)
    {
        $relationships = $this->repository
            ->findBy(
                array('contentId' => $content->getId())
            );

        foreach ($relationships as $relationship) {
            if (array_search($relationship->getCategoryId(), $content->getCategoryIds()) === false) {
                $this->em->remove($relationship);
                $this->em->flush();
            }
        }

        foreach ($content->getCategoryIds() as $categoryId) {
            $exists = false;
            foreach ($relationships as $relationship) {
                if ($relationship->getCategoryId() == $categoryId) {
                    $exists = true;
                    break;
                }
            }
            if ($exists === false) {
                $newRelationship = new $this->class();
                $newRelationship->setCategoryId($categoryId);
                $newRelationship->setContentId($content->getId());
                $this->em->persist($newRelationship);
                $this->em->flush();
            }
        }
    }

    public function getCategoryIds($contentId)
    {
        $relationships = $this->repository
            ->findBy(
                array('contentId' => $contentId)
            );

        $categoryIds = array();
        foreach ($relationships as $relationship) {
            $categoryIds[] = $relationship->getCategoryId();
        }

        return $categoryIds;
    }
}
