<?php

namespace Bloq\Common\EditorBundle\Manager;

class EditorialContentManager
{
    const DOCTRINE_ENTITY_MANAGER_CLASS = "Doctrine\\ORM\\EntityManager";
    const DOCTRINE_SERVICE_CLASS = "Doctrine\\Bundle\\DoctrineBundle\\Registry";
    const CATEGORY_ENTITY_CALSS = "Bloq\\Common\\EditorBundle\\Entity\\Category";
    const TAG_ENTITY_CALSS = "Bloq\\Common\\EditorBundle\\Entity\\Tag";

    protected $em;
    protected $repository;
    protected $categoryRepository;
    protected $tagRepository;
    protected $class;

    public function __construct($doctrine, $class)
    {
        $doctrineServiceClass = self::DOCTRINE_SERVICE_CLASS;
        $doctrineEntityManager = self::DOCTRINE_ENTITY_MANAGER_CLASS;

        $categoryEntityClass = self::CATEGORY_ENTITY_CALSS;
        $tagEntityClass = self::TAG_ENTITY_CALSS;

        if ($doctrine instanceof $doctrineEntityManager) {
            $this->em = $doctrine;
        } elseif ($doctrine instanceof $doctrineServiceClass) {
            $this->em = $doctrine->getManager('content');
        }
        $this->class = $class;
        $this->repository = $this->em->getRepository($this->class);
        $this->categoryRepository = $this->em->getRepository($categoryEntityClass);
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

    public function saveEditorialContent($object, $andFlush = true)
    {
        $this->em->persist($object);
        if ($andFlush) {
            $this->em->flush();
        }

        return $object->getId();
    }

    public function disableById($id)
    {
        $content = $this->repository
            ->find($id);

        $content->setEnabled(false);

        $this->save($content);
    }

    public function getAllByStatus($status) {
        $contents = $this->repository
            ->findBy(
                array("status" => $status),
                array('createdDT' => 'DESC')
            );

        return $contents;
    }

    public function cleanup()
    {
        $this->em->clear();
    }

    public function createEditorialContent()
    {
        $class = $this->getClass();
        $content = new $class;

        return $content;
    }
}
