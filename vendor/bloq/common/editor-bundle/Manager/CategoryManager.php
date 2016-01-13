<?php

namespace Bloq\Common\EditorBundle\Manager;

class CategoryManager
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
                $conditionArray[] .= "category.id=".$id;
            }
            $whereQuery = " WHERE ".implode(" OR ", $conditionArray);

            $contents = $this->em->createQuery("SELECT category FROM ".$this->class." category".$whereQuery)->getResult();
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

    public function getAllByParent($parentId)
    {
        $contents = $this->repository
            ->findBy(
                array("parentId" => $parentId)
            );

        if (null === $contents) {
            $contents = array();
        }
        
        return $contents;
    }

    public function getByChild($childId)
    {
        $children = $this->repository
            ->find(
                array($childId)
            );

        if ($children[0]->getParentId() > 0){
            $contents = $this->repository
                ->find(
                    array($children[0]->getParentId())
                );

            if (null === $contents) {
                $content = null;
            } else {
                $content = $contents[0];
            }
        } else {
            $content = null;
        }

        return $content;
    }

    public function getDescendenceIdsByIds($ids, $onlyEnabled = true)
    {
        $results = array();
        foreach ($ids as $id) {
            if ($onlyEnabled) {
                $childs = $this->getEnabledByParent($id);
            } else {
                $childs = $this->getAllByParent($id);
            }
            foreach ($childs as $child) {
                $results[] = $child->getId();
            }
            $results = array_merge($results, $this->getDescendenceIdsByIds($results, $onlyEnabled));
        }

        return $results;
    }

    public function getEnabledByParent($parentId)
    {
        $contents = $this->em->createQuery("SELECT category FROM ".$this->class." category WHERE category.enabled = true AND category.parentId = ".$parentId)->getResult();

        if (null === $contents) {
            $contents = array();
        }

        return $contents;
    }

    public function getMenuAdded()
    {
        $contents = $this->em->createQuery("SELECT category FROM ".$this->class." category WHERE category.enabled = true AND category.menuPosition != 0 ORDER BY category.menuPosition")->getResult();

        if (null === $contents) {
            $contents = array();
        } else {
            foreach ($contents as $content) {
                $content->setUrl($this->getUrl($content));
            }
        }

        return $contents;
    }

    public function getOutOfMenu()
    {
        $contents = $this->em->createQuery("SELECT category FROM ".$this->class." category WHERE category.enabled = true AND category.menuPosition = 0 AND category.parentId = 0")->getResult();

        if (null === $contents) {
            $contents = array();
        }

        return $contents;
    }

    public function setInMenuPosition($id, $position)
    {
        $contents = $this->repository
            ->findBy(
                array('id' => $id)
            );

        if ($contents!=null && count($contents)>0) {
            $contents[0]->setMenuPosition($position);
            $this->save($contents[0]);
        }

        return $contents[0];
    }

    public function cleanMenu()
    {
        $contents = $this->getMenuAdded();
        foreach ($contents as $content) {
            $content->setMenuPosition(0);
            $this->save($content);
        }

        return true;
    }

    public function save($object)
    {
        if ($object->getEnabled() === null) {
            $object->setEnabled(false);
        }

        if ($object->getParentId() === null) {
            $object->setParentId(0);
        }

        if ($object->getMenuPosition() == null) {
            $object->setMenuPosition(0);
        }

        if ($object->getOutstanding() == null) {
            $object->setOutstanding(0);
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

    public function getOutstandings()
    {
        $query = $this->em
            ->createQuery(
                "SELECT category
                FROM ".$this->class." category
                WHERE category.enabled = true
                AND category.outstanding != 0
                ORDER BY category.outstanding ASC"
            );

        $contents = $query->getResult();

        return $contents;
    }

    public function getNotOutstandings()
    {
        $query = $this->em
            ->createQuery(
                "SELECT category
                FROM ".$this->class." category
                WHERE category.enabled = true
                AND category.outstanding = 0"
            );

        $contents = $query->getResult();

        return $contents;
    }

    public function cleanOutstandings()
    {
        $outstandings = $this->getOutstandings();
        foreach ($outstandings as $content) {
            $content->setOutstanding(0);
            $this->save($content);
        }

        return true;
    }

    public function setInOutstandingsPosition($contentId, $position)
    {
        $content = $this->getById($contentId);
        if ($content != null) {
            $content->setOutstanding($position);
            $this->save($content);
        }

        return $content;
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

    public function getUrl($category)
    {
        if ($category->getParentId() > 0) {
            $parent = $this->getById($category->getParentId());
            $url = $this->getUrl($parent).$category->getSlug()."/";
        } else {
            $url = "/".$category->getSlug()."/";
        }

        return $url;
    }
}
