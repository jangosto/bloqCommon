<?php

namespace Bloq\Common\EditorBundle\Manager;

class TagManager
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

    public function getAll()
    {
        $contents = $this->repository
            ->findAll();

        if (null === $contents) {
            $contents = array();
        }

        return $contents;
    }

    public function getById($id)
    {
        $content = $this->repository
            ->findBy(
                array("id" => $id)
            );

        if (null === $content) {
            $content = null;
        }

        return $content[0];
    }

    public function getAllByParent($id)
    {
        $parentContent = $this->repository
            ->findBy(
                array("id" => $id)
            );

        if (null === $parentContent) {
            $content = array();
        } else {
            $content = $parentContent->getChildren();
        }
        
        return $content;
    }

    public function save($object)
    {
        $this->em->persist($object);
        $this->em->flush();

        return $object->getId();
    }

    public function disableById($id)
    {
        $content = $this->repository
            ->find($id);

        $content->setEnabled(false);

        $this->save($content);
    }
}
