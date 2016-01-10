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

    public function getAllEnabled()
    {
        $contents = $this->repository
            ->findBy(array(
                'enabled' => true
            ));

        if (null === $contents) {
            $contents = array();
        }

        return $contents;
    }

    public function getById($id)
    {
        $contents = $this->repository
            ->findBy(
                array("id" => $id)
            );

        if (null === $contents || count($contents) == 0) {
            $content = null;
        } else {
            foreach ($contents as $content) {
                $content->setUrl($this->getUrl($content));
                if ($content->getParentId() != 0) {
                    $content->setParent($this->getById($content->getParentId()));
                }
            }
            $content = $contents[0];
        }

        return $content;
    }

    public function getByIds(array $ids)
    {
        $contents = null;

        if(count($ids) > 0) {
            $conditionArray = array();

            foreach ($ids as $id) {
                $conditionArray[] .= "tag.id=".$id;
            }
            $whereQuery = " WHERE ".implode(" OR ", $conditionArray);

            $contents = $this->em->createQuery("SELECT tag FROM ".$this->class." tag".$whereQuery)->getResult();
        }

        if (null === $contents) {
            $contents = array();
        } else {
            foreach ($contents as $content) {
                $content->setUrl($this->getUrl($content));
            }
        }

        return $contents;
    }

    public function getBySlug($slug)
    {
        $contents = $this->repository
            ->findBy(
                array("slug" => $slug)
            );

        if (null === $contents || count($contents) == 0) {
            $content = null;
        } else {
            foreach ($contents as $content) {
                $content->setUrl($this->getUrl($content));
            }
            $content = $contents[0];
        }

        return $content;
    }

    public function getAllByParent($id)
    {
        $contents = $this->repository
            ->findBy(
                array("parentId" => $id)
            );

        if (null === $contents) {
            $contents = array();
        }

        return $contents;
    }

    public function save($object)
    {
        if ($object->getEnabled() === null) {
            $object->setEnabled(false);
        }

        if ($object->getParentId() === null) {
            $object->setParentId(0);
        }

        $this->em->persist($object);
        $this->em->flush();

        return $object->getId();
    }

    public function disableById($id)
    {
        $content = $this->repository
            ->find($id);

        $content->setEnabled(false);

        $children = $this->repository
            ->findBy(array(
                'parentId' => $content->getId()
            ));

        foreach ($children as $child) {
            $this->disableById($child->getId());
        }

        $this->save($content);
    }

    public function enableById($id)
    {
        $content = $this->repository
            ->find($id);

        $content->setEnabled(true);

        if ($content->getParentId() !== null && $content->getParentId() !== 0) {
            $this->enableById($content->getParentId());
        }

        $this->save($content);
    }

    public function cleanup()
    {
        $this->em->clear();
    }

    public function getAllWithHierarchy($onlyEnabled = false)
    {
        if ($onlyEnabled === true) {
            $contents = $this->repository
                ->findBy(array(
                    'enabled' => true
                ));
        } else {
            $contents = $this->repository
                ->findAll();
        }

        return $this->buildTree($contents);
    }

    private function buildTree($elements, $parentId = 0)
    {
        $branch = array();

        foreach ($elements as $element) {
            if ($element->getParentId() == $parentId) {
                $children = $this->buildTree($elements, $element->getId());
                if ($children) {
                    $element->setChildren($children);
                }
                $branch[] = $element;
            }
        }

        return $branch;
    }

    public function getUrl($tag)
    {
        if ($tag->getParentId() > 0) {
            $parent = $this->getById($tag->getParentId());
            $url = $this->getUrl($parent).$tag->getSlug()."/";
        } else {
            $url = "/".$tag->getSlug()."/";
        }

        return $url;
    }
}
