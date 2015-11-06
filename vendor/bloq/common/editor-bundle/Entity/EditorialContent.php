<?php

namespace Bloq\Common\EditorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Bloq\Common\EditorBundle\Entity\Url;
use Bloq\Common\EditorBundle\Entity\Category;
use Bloq\Common\EditorBundle\Entity\Tag;
use Bloq\Common\EditorBundle\Entity\EditorialContentInterface;


/**
 * @ORM\Entity
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type_class", type="string")
 * @ORM\DiscriminatorMap({
 *      "Bloq\Common\EditorBundle\Entity\EditorialContent" = "Bloq\Common\EditorBundle\Entity\EditorialContent",
 *      "Bloq\Common\EditorBundle\Entity\Article" = "Bloq\Common\EditorBundle\Entity\Article",
 *      "Bloq\Common\EditorBundle\Entity\Gallery" = "Bloq\Common\EditorBundle\Entity\Gallery",
 *      "AppBundle\Entity\Article" = "AppBundle\Entity\Article",
 *      "AppBundle\Entity\Gallery" = "AppBundle\Entity\Gallery"
 * })
 */
class EditorialContent implements EditorialContentInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $type;

    /**
     * @ORM\Column(type="integer", nullable=false)
     * @var integer
     */
    protected $sectionId;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $pretitle;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $title;

    /**
     * @ORM\Column(type="array", nullable=true)
     * @var string
     */
    protected $subtitles;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @var string
     */
    protected $intro;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @var string
     */
    protected $text;

    /**
     * @ORM\ManyToMany(targetEntity="Bloq\Common\MultimediaBundle\Entity\Multimedia", cascade={"persist", "remove"})
     * @ORM\JoinTable(
     *      name="contents_multimedias",
     *      joinColumns={@ORM\JoinColumn(name="content_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="multimedia_id", referencedColumnName="id")}
     *      )
     */
    protected $multimedias;

    /**
     * @ORM\Column(type="array", nullable=true)
     * @var string
     */
    protected $summaries;

    /**
     * @ORM\Column(type="array", nullable=true)
     * @var array
     */
    protected $authors;

    /**
     * @var array
     */
    protected $categoryIds;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @var bool
     */
    protected $useCategoryAsPretitle;

    /**
     * @ORM\OneToMany(targetEntity="Bloq\Common\EditorBundle\Entity\Url", mappedBy="content")
     */
    protected $urls;

    /**
     * @var array
     */
    protected $tagIds;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $status;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var datetime
     */
    protected $createdDT;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var datetime
     */
    protected $publishedDT;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var datetime
     */
    protected $updatedDT;


    public function __construct()
    {
        $this->authors = array();
        $this->subtitles = array();
        $this->summaries = array();
        $this->urls = new ArrayCollection();
        $this->categoryIds = array();
        $this->tags = array();
        $this->multimedias = new ArrayCollection();
    }

    /**
     * Add subtitle
     *
     * @param subtitle
     */
    public function addSubtitle($subtitle)
    {
        $this->subtitles[] = $subtitle;

        return $this;
    }

    /**
     * Remove subtitle
     *
     * @param subtitle position
     */
    public function removeSubtitle($subtitle)
    {
        if (false !== $key = array_search($subtitle, $this->subtitles, true)) {
            unset($this->subtitles[$key]);
            $this->subtitles = array_values($this->subtitles);
        }

        return $this;
    }

    /**
     * Add summary
     *
     * @param summary
     */
    public function addSummary($summary)
    {
        $this->summaries[] = $summary;

        return $this;
    }

    /**
     * Remove summary
     *
     * @param summary position
     */
    public function removeSummary($summary)
    {
        if (false !== $key = array_search($summary, $this->summaries, true)) {
            unset($this->summaries[$key]);
            $this->summaries = array_values($this->summaries);
        }

        return $this;
    }

    /**
     * Add author
     *
     * @param author id (external database)
     */
    public function addAuthor($author)
    {
        if (!in_array($author, $this->authors, true)) {
            $this->authors[] = $author;
        }

        return $this;
    }

    /**
     * Remove author
     *
     * @param author id (external database)
     */
    public function removeAuthor($author)
    {
        if (false !== $key = array_search($author, $this->authors, true)) {
            unset($this->authors[$key]);
            $this->authors = array_values($this->authors);
        }

        return $this;
    }

    /**
     * Add url
     *
     * @param Url url
     */
    public function addUrl(Url $url)
    {
        $url->setContent($this);
        $this->urls[] = $url;

        return $this;
    }

    /**
     * Remove url
     *
     * @param Url url
     */
    public function removeUrl(Url $url)
    {
        $this->urls->removeElement($url);
        $url->setContent(null);

        return $this;
    }

    /**
     * Add category
     *
     * @param Category category
     */
    public function addCategoryId($categoryId)
    {
        $this->categoryIds[] = $categoryId;

        return $this;
    }

    /**
     * Remove category
     *
     * @param Category category
     */
    public function removeCategoryId($categoryId)
    {
        if ($key = array_search($categoryId, $this->categoryIds) !== false) {
            unset($this->categoryIds[$key]);
            $this->categoryIds = array_values($this->categoryIds);
        }

        return $this;
    }

    /**
     * Add tag
     *
     * @param Tag tag
     */
    public function addTagId($tagId)
    {
        $this->tagIds[] = $tagId;

        return $this;
    }

    /**
     * Remove tag
     *
     * @param Tag tag
     */
    public function removeTagId($tagId)
    {
        if ($key = array_search($tagId, $this->tagIds) !== false) {
            unset($this->tagIds[$key]);
            $this->tagIds = array_values($this->tagIds);
        }

        return $this;
    }

    /**
     * Get id.
     *
     * @return id.
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Set id.
     *
     * @param id the value to set.
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    
    /**
     * Get pretitle.
     *
     * @return pretitle.
     */
    public function getPretitle()
    {
        return $this->pretitle;
    }
    
    /**
     * Set pretitle.
     *
     * @param pretitle the value to set.
     */
    public function setPretitle($pretitle)
    {
        $this->pretitle = $pretitle;
    }
    
    /**
     * Get title.
     *
     * @return title.
     */
    public function getTitle()
    {
        return $this->title;
    }
    
    /**
     * Set title.
     *
     * @param title the value to set.
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }
    
    /**
     * Get subtitles.
     *
     * @return subtitles.
     */
    public function getSubtitles()
    {
        return $this->subtitles;
    }
    
    /**
     * Set subtitles.
     *
     * @param subtitles the value to set.
     */
    public function setSubtitles($subtitles)
    {
        $this->subtitles = array_values($subtitles);
    }
    
    /**
     * Get text.
     *
     * @return text.
     */
    public function getText()
    {
        return $this->text;
    }
    
    /**
     * Set text.
     *
     * @param text the value to set.
     */
    public function setText($text)
    {
        $this->text = $text;
    }
    
    /**
     * Get authors.
     *
     * @return authors.
     */
    public function getAuthors()
    {
        return $this->authors;
    }
    
    /**
     * Set authors.
     *
     * @param authors the value to set.
     */
    public function setAuthors($authors)
    {
        $this->authors = $authors;
    }
    
    /**
     * Get urls.
     *
     * @return urls.
     */
    public function getUrls()
    {
        return $this->urls;
    }
    
    /**
     * Set urls.
     *
     * @param urls the value to set.
     */
    public function setUrls($urls)
    {
        $this->urls = $urls;
    }
    
    /**
     * Get status.
     *
     * @return status.
     */
    public function getStatus()
    {
        return $this->status;
    }
    
    /**
     * Set status.
     *
     * @param status the value to set.
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }
    
    /**
     * Get createdDT.
     *
     * @return createdDT.
     */
    public function getCreatedDT()
    {
        return $this->createdDT;
    }
    
    /**
     * Set createdDT.
     *
     * @param createdDT the value to set.
     */
    public function setCreatedDT($createdDT)
    {
        $this->createdDT = $createdDT;
    }
    
    /**
     * Get publishedDT.
     *
     * @return publishedDT.
     */
    public function getPublishedDT()
    {
        return $this->publishedDT;
    }
    
    /**
     * Set publishedDT.
     *
     * @param publishedDT the value to set.
     */
    public function setPublishedDT($publishedDT)
    {
        $this->publishedDT = $publishedDT;
    }
    
    /**
     * Get updatedDT.
     *
     * @return updatedDT.
     */
    public function getUpdatedDT()
    {
        return $this->updatedDT;
    }
    
    /**
     * Set updatedDT.
     *
     * @param updatedDT the value to set.
     */
    public function setUpdatedDT($updatedDT)
    {
        $this->updatedDT = $updatedDT;
    }
    
    /**
     * Get intro.
     *
     * @return intro.
     */
    public function getIntro()
    {
        return $this->intro;
    }
    
    /**
     * Set intro.
     *
     * @param intro the value to set.
     */
    public function setIntro($intro)
    {
        $this->intro = $intro;
    }
    
    /**
     * Get useCategoryAsPretitle.
     *
     * @return useCategoryAsPretitle.
     */
    public function getUseCategoryAsPretitle()
    {
        return $this->useCategoryAsPretitle;
    }
    
    /**
     * Set useCategoryAsPretitle.
     *
     * @param useCategoryAsPretitle the value to set.
     */
    public function setUseCategoryAsPretitle($useCategoryAsPretitle)
    {
        $this->useCategoryAsPretitle = $useCategoryAsPretitle;
    }
    
    /**
     * Get categoryIds.
     *
     * @return categoryIds.
     */
    public function getCategoryIds()
    {
        return $this->categoryIds;
    }
    
    /**
     * Set categoryIds.
     *
     * @param categoryIds the value to set.
     */
    public function setCategoryIds($categoryIds)
    {
        $this->categoryIds = $categoryIds;
    }
    
    /**
     * Get tagIds.
     *
     * @return tagIds.
     */
    public function getTagIds()
    {
        return $this->tagIds;
    }
    
    /**
     * Set tagIds.
     *
     * @param tagIds the value to set.
     */
    public function setTagIds($tagIds)
    {
        $this->tagIds = $tagIds;
    }
    
    /**
     * Get multimedias.
     *
     * @return multimedias.
     */
    public function getMultimedias()
    {
        return $this->multimedias;
    }
    
    /**
     * Set multimedias.
     *
     * @param multimedias the value to set.
     */
    public function setMultimedias($multimedias)
    {
        $this->multimedias = $multimedias;
    }
    
    /**
     * Get summaries.
     *
     * @return summaries.
     */
    public function getSummaries()
    {
        return $this->summaries;
    }
    
    /**
     * Set summaries.
     *
     * @param summaries the value to set.
     */
    public function setSummaries($summaries)
    {
        $this->summaries = $summaries;
    }
    
    /**
     * Get sectionId.
     *
     * @return sectionId.
     */
    public function getSectionId()
    {
        return $this->sectionId;
    }
    
    /**
     * Set sectionId.
     *
     * @param sectionId the value to set.
     */
    public function setSectionId($sectionId)
    {
        $this->sectionId = $sectionId;
    }
}

