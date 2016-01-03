<?php

namespace Bloq\Common\EditorBundle\Manager;

class ContentsCategoriesManager
{
    const DOCTRINE_ENTITY_MANAGER_CLASS = "Doctrine\\ORM\\EntityManager";
    const DOCTRINE_SERVICE_CLASS = "Doctrine\\Bundle\\DoctrineBundle\\Registry";

    protected $em;
    protected $repository;
    protected $class;
    protected $categoryManager;

    public function __construct($doctrine, $class, $categoryManager)
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
        $this->categoryManager = $categoryManager;
    }

    public function saveRelationships($content)
    {
        $relationships = $this->repository
            ->findBy(
                array('contentId' => $content->getId())
            );

        if ($content->getCategoryIds() === null) {
            $categoryIds = array();
        } else {
            $categoryIds = $content->getCategoryIds();
        }

        foreach ($categoryIds as $id) {
            $tempCategory = $this->categoryManager->getById($id);
            while (($tempCategory = $this->categoryManager->getById($tempCategory->getParentId())) != null) {
                if (array_search($tempCategory->getId(), $categoryIds) === false) {
                    $categoryIds[] = $tempCategory->getId();
                }
            }
        }

        foreach ($relationships as $relationship) {
            if (array_search($relationship->getCategoryId(), $categoryIds) === false) {
                $this->em->remove($relationship);
                $this->em->flush();
            }
        }

        foreach ($categoryIds as $categoryId) {
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

    public function getContentIdsByCategoryIds(array $categoryIds, $strict = false)
    {
        $whereCondition = implode(" OR relationship.categoryId=", $categoryIds);
        $whereCondition = " WHERE relationship.categoryId=".$whereCondition;

        $relationships = $this->em
            ->createQuery(
                'SELECT relationship FROM '.$this->class.' relationship'.$whereCondition.' GROUP BY relationship.contentId'
            )->getResult();

        $contentIds = array();
        foreach ($relationships as $relationship) {
            $contentIds[] = $relationship->getContentId();
        }

        return $contentIds;
    }
}
