<?php

namespace Bloq\Common\EditorBundle\Manager;

class ContentsTagsManager
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

        if ($content->getTagIds() === null) {
            $tagIds = array();
        } else {
            $tagIds = $content->getTagIds();
        }

        foreach ($relationships as $relationship) {
            if (array_search($relationship->getTagId(), $tagIds) === false) {
                $this->em->remove($relationship);
                $this->em->flush();
            }
        }

        foreach ($tagIds as $tagId) {
            $exists = false;
            foreach ($relationships as $relationship) {
                if ($relationship->getTagId() == $tagId) {
                    $exists = true;
                    break;
                }
            }
            if ($exists === false) {
                $newRelationship = new $this->class();
                $newRelationship->setTagId($tagId);
                $newRelationship->setContentId($content->getId());
                $this->em->persist($newRelationship);
                $this->em->flush();
            }
        }
    }

    public function getTagIds($contentId)
    {
        $relationships = $this->repository
            ->findBy(
                array('contentId' => $contentId)
            );

        $tagIds = array();
        foreach ($relationships as $relationship) {
            $tagIds[] = $relationship->getTagId();
        }

        return $tagIds;
    }

    public function getContentIdsByTagIds(array $tagIds, $strict = false)
    {
        $whereCondition = implode(" OR relationship.tagId=", $tagIds);
        $whereCondition = " WHERE relationship.tagId=".$whereCondition;

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
