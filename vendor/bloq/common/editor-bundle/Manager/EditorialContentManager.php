<?php

namespace Bloq\Common\EditorBundle\Manager;

class EditorialContentManager
{
    const DOCTRINE_ENTITY_MANAGER_CLASS = "Doctrine\\ORM\\EntityManager";
    const DOCTRINE_SERVICE_CLASS = "Doctrine\\Bundle\\DoctrineBundle\\Registry";

    protected $em;
    protected $repository;
    protected $categoryClass;
    protected $categoryManager;
    protected $ecCategoryManager;
    protected $ecTagManager;
    protected $class;

    public function __construct(
        $doctrine,
        $class,
        $categoryManager,
        $ecCategoryManager,
        $tagManager,
        $ecTagManager
    ) {
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
        $this->ecCategoryManager = $ecCategoryManager;
        $this->tagManager = $tagManager;
        $this->ecTagManager = $ecTagManager;
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

    public function getById($id, $complete = false)
    {
        $contents = $this->repository
            ->findBy(
                array("id" => $id)
            );

        if (null === $contents) {
            $content = null;
        } elseif ($complete === true) {
            $content = $contents[0];
            $content = $this->setECCategoryIds($content);
            $content = $this->setECTagIds($content);
            $content = $this->setECCategories($content);
            $content = $this->setECTags($content);
            $content = $this->setSection($content);
        } else {
            $content = $contents[0];
        }

        return $content;
    }

    public function getByIds(array $ids, $limit = null)
    {
        $contents = null;

        if(count($ids) > 0) {
            $conditionArray = array();

            foreach ($ids as $id) {
                $conditionArray[] .= "editorial_content.id=".$id;
            }
            $whereQuery = " WHERE ".implode(" OR ", $conditionArray);

            $query = $this->em->createQuery("SELECT editorial_content FROM ".$this->class." editorial_content".$whereQuery.'ORDER BY editorial_content.publishedDT DESC');
            if ($limit !== null && is_int($limit)) {
                $query->setMaxResults($limit);
            }

            $contents = $query->getResult();
        }

        if (null === $contents) {
            $contents = array();
        }

        return $contents;
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

    public function getByTagIds($tagIds, $limit = null)
    {
        $contentIds = $this->ecTagManager->getContentIdsByTagIds($content->getTagIds());
        $contents = $this->getByIds($contentIds, $limit);

        return $contents;
    }

    public function getBySameTags($content, $strict = false, $limit = null)
    {
        $contentIds = $this->ecTagManager->getContentIdsByTagIds($content->getTagIds());
        unset($contentIds[array_search($content->getId(), $contentIds)]);

        $contents = $this->getByIds($contentIds, $limit);

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

    private function setECCategoryIds($content)
    {
        $categoryIds = $this->ecCategoryManager->getCategoryIds($content->getId());
        $content->setCategoryIds($categoryIds);

        return $content;
    }

    private function setECTagIds($content)
    {
        $tagIds = $this->ecTagManager->getTagIds($content->getId());
        $content->setTagIds($tagIds);

        return $content;
    }

    private function setECCategories($content)
    {
        $categories = $this->categoryManager->getByIds($content->getCategoryIds());

        $content->setCategories($categories);

        return $content;
    }

    private function setECTags($content)
    {
        $tags = $this->tagManager->getByIds($content->getTagIds());

        $content->setTags($tags);

        return $content;
    }

    private function setSection($content)
    {
        $section = $this->categoryManager->getById($content->getSectionId());

        $content->setSection($section);

        return $content;
    }
}
