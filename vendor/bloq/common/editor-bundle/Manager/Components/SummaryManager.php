<?php

namespace Bloq\Common\EditorBundle\Manager\Components;

class SummaryManager
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

    public function getById($id)
    {
        $contents = $this->repository
            ->findBy(
                array("id" => $id)
            );

        if (null === $contents) {
            $content = null;
        } else {
            $content = $contents[0];
        }

        return $content;
    }

    public function getByIds($ids)
    {
        $contents = null;

        if(count($ids) > 0) {
            $conditionArray = array();

            foreach ($ids as $id) {
                $conditionArray[] .= "summary.id=".$id;
            }
            $whereQuery = " WHERE ".implode(" OR ", $conditionArray);

            $contents = $this->em->createQuery("SELECT summary FROM ".$this->class." summary".$whereQuery." ORDER BY summary.position ASC")->getResult();
        }

        if (null === $contents) {
            $contents = array();
        }

        return $contents;
    }

    public function save($object)
    {
        $this->em->persist($object);
        $this->em->flush();

        return $object->getId();
    }
}
