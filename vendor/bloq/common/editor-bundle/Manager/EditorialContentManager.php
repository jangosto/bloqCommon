<?php

namespace Bloq\Common\EditorBundle\Manager;

class EditorialContentManager
{
    const DOCTRINE_ENTITY_MANAGER_CLASS = "Doctrine\\ORM\\EntityManager";
    const DOCTRINE_SERVICE_CLASS = "Doctrine\\Bundle\\DoctrineBundle\\Registry";

    protected $em;
    protected $repository;
    protected $ECType;
    protected $urlManager;
    protected $categoryClass;
    protected $categoryManager;
    protected $ecCategoryManager;
    protected $ecTagManager;
    protected $class;

    public function __construct(
        $doctrine,
        $ECType,
        $class,
        $urlManager,
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
        $this->ECType = $ECType;
        $this->repository = $this->em->getRepository($this->class);
        $this->urlManager = $urlManager;
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
            $content = $this->setUrls($content);
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
            $whereQuery = " WHERE (".implode(" OR ", $conditionArray).")";

            $query = $this->em->createQuery("SELECT editorial_content FROM ".$this->class." editorial_content".$whereQuery." AND editorial_content.status='published' ORDER BY editorial_content.publishedDT DESC");
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
        if ($object->getType() === null) {
            $object->setType($this->ECType);
        }

        if ($object->getOutstanding() === null) {
            $object->setOutstanding(0);
        }

        if ($object->getSeoTitle() === null) {
            $object->setSeoTitle(false);
        }

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

    public function getAllByStatus($status, $limit = 0, $offset = 0) {
        if ($limit > 0) {
            $contents = $this->repository
                ->findBy(
                    array("status" => $status),
                    array('createdDT' => 'DESC'),
                    $limit,
                    $offset
                );
        } else {
            $contents = $this->repository
                ->findBy(
                    array("status" => $status),
                    array('createdDT' => 'DESC')
                );
        }
    
        return $contents;
    }

    public function getByTagIds($tagIds, $limit = null)
    {
        $contentIds = $this->ecTagManager->getContentIdsByTagIds($tagIds);
        $contents = $this->getByIds($contentIds, $limit);

        return $contents;
    }

    public function getByCategoryIds($categoryIds, $limit = null, $excludedContents = array())
    {
        $contentIds = $this->ecCategoryManager->getContentIdsByCategoryIds($categoryIds);

        foreach ($excludedContents as $id) {
            if (($index = array_search($id, $contentIds)) !== false) {
                unset($contentIds[$index]);
            }
        }
        $contents = $this->getByIds($contentIds, $limit);

        return $contents;
    }

    public function getBySectionIdAndChildSectionIds($sectionId, $limitBySection = null, $excludedContents = array())
    {
        $sectionIds = $this->categoryManager->getDescendenceIdsByIds(array($sectionId));

        $sectionIds[] = $sectionId;

        $query = "AND (editorial_content.sectionId = ".implode(" OR editorial_content.sectionId = ", $sectionIds).")";

        $contents = $this->getOrderedByDate($limitBySection, $excludedContents, $query);

        return $contents;
    }

    public function getOutstandings($limit = 0, $excludedContents = array(), $extraFilter = "")
    {
        if (count($excludedContents) > 0) {
            $excludeQuery = " AND editorial_content.id != ".implode(" AND editorial_content.id != ", $excludedContents)." ";
        } else {
            $excludeQuery = "";
        }

        $query = $this->em
            ->createQuery(
                "SELECT editorial_content
                FROM ".$this->class." editorial_content
                WHERE editorial_content.status = 'published'
                AND editorial_content.outstanding > 0 "
                .$excludeQuery.$extraFilter.
                " ORDER BY editorial_content.outstanding ASC"
            );
        if ($limit != 0) {
            $query->setMaxResults($limit);
        }
    
        $contents = $query->getResult();

        return $contents;
    }

    public function getNotOutstandings($limit = 0, $offset = 0)
    {
        $query = $this->em
            ->createQuery(
                "SELECT editorial_content
                FROM ".$this->class." editorial_content
                WHERE editorial_content.status = 'published'
                AND editorial_content.outstanding = 0
                ORDER BY editorial_content.publishedDT DESC"
            );

        if ($limit != 0) {
            $query->setMaxResults($limit);
        }
        if ($offset != 0) {
            $query->setFirstResult($offset);
        }

        $contents = $query->getResult();

        if ($contents==null || count($contents)<=0) {
            $contents = array();
        }

        return $contents;
    }

    public function setInOutstandingsPosition($contentId, $position)
    {
        $content = $this->getById($contentId);
        if ($content != null) {
            $content->setOutstanding($position);
            $this->saveEditorialContent($content);
        }

        return $content;
    }

    public function cleanOutstandings()
    {
        $outstandings = $this->getOutstandings();
        foreach ($outstandings as $content) {
            $content->setOutstanding(0);
            $this->saveEditorialContent($content);
        }

        return true;
    }

    public function getOrderedByDate($limit = 0, $excludedContents = null, $extraFilter = '')
    {
        if (count($excludedContents) > 0) {
            $excludeQuery = " AND editorial_content.id != ".implode(" AND editorial_content.id != ", $excludedContents);
        } else {
            $excludeQuery = "";
        }

        $query = $this->em
            ->createQuery(
                "SELECT editorial_content
                FROM ".$this->class." editorial_content
                WHERE editorial_content.status = 'published'"
                .$excludeQuery." ".$extraFilter.
                " ORDER BY editorial_content.publishedDT DESC"
            );
        if ($limit != 0) {
            $query->setMaxResults($limit);
        }

        $contents = $query->getResult();

        return $contents;
    }
    
    public function getBySameTags($content, $strict = false, $limit = null, $excludedContents = array())
    {
        $contentIds = $this->ecTagManager->getContentIdsByTagIds($content->getTagIds());

        foreach ($excludedContents as $excludedContentId) {
            unset($contentIds[array_search($excludedContentId, $contentIds)]);
        }

        $contents = $this->getByIds($contentIds, $limit);

        return $contents;
    }

    public function searchByTitle($string, $limit = 0, $offset = 0, $extraFilter = "")
    {
        $query = $this->em
            ->createQuery(
                "SELECT editorial_content
                FROM ".$this->class." editorial_content
                WHERE editorial_content.status = 'published' "
                .$extraFilter.
                " AND editorial_content.title LIKE '%".$string."%'
                ORDER BY editorial_content.publishedDT DESC"
            );
        if ($limit != 0) {
            $query->setMaxResults($limit);
        }
        if ($offset != 0) {
            $query->setFirstResult($offset);
        }

        $contents = $query->getResult();

        if ($contents==null || count($contents)<=0) {
            $contents = array();
        }

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

    private function setUrls($content)
    {
        $urls = $this->urlManager->getByContentId($content->getId());

        $content->setUrls($urls);

        return $content;
    }

    public function setDataForRepresentation($content)
    {
        $content = $this->setSection($content);
        $content = $this->setUrls($content);
        foreach ($content->getMultimedias() as $multimedia) {
            if ($multimedia->getPosition() == "primary") {
                $content->setMultimedias(array($multimedia));
            }
        }

        return $content;
    }
}
