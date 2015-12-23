<?php

namespace Bloq\Common\MultimediaBundle\Manager;

use Bloq\Common\MultimediaBundle\Lib\Globals;

class MultimediaManager
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
        $multimedias = $this->repository
            ->findAll();

        if (null === $multimedias) {
            $multimedias = array();
        }

        return $multimedias;
    }

    public function getAllByType($type)
    {
        $multimedias = $this->repository
            ->findBy(
                array('type' => $type)
            );

        if (null === $multimedias) {
            $multimedias = array();
        }

        return $multimedias;
    }

    public function getById($id)
    {
        $multimedia = $this->repository
            ->findBy(
                array("id" => $id)
            );

        if (null === $multimedia) {
            $multimedia = null;
        }

        return $multimedia[0];
    }

    public function save($object)
    {
        $this->em->persist($object);
        $this->em->flush();

        return $object->getId();
    }

    public function saveMultimediaItem($multimedia)
    {
        if ($multimedia->getType() == "image" && $multimedia->getFile() !== null) {
            $uploadRootPath = $multimedia->getOriginalImagesRootDir();

            $extension = $multimedia->getFile()->guessExtension();
            $filename = rand(1, 9999999).'.'.$extension;
            $dateDirPart = date("Y/md");

            $absDir = $uploadRootPath."/".$dateDirPart;

            $multimedia->getFile()->move($absDir, $filename);
            $multimedia->setPath("/".$dateDirPart."/".$filename);
        }
    }
}
