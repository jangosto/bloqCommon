<?php

namespace Bloq\Common\EditorBundle\Manager;

class UrlManager
{
    const DOCTRINE_ENTITY_MANAGER_CLASS = "Doctrine\\ORM\\EntityManager";
    const DOCTRINE_SERVICE_CLASS = "Doctrine\\Bundle\\DoctrineBundle\\Registry";

    protected $em;
    protected $repository;
    protected $class;
    protected $sectionManager;

    public function __construct($doctrine, $class, $sectionManager)
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
        $this->sectionManager = $sectionManager;
    }

    public function getAll()
    {
        $urls = $this->repository
            ->findAll();

        if (null === $urls) {
            $urls = array();
        }

        return $urls;
    }
    
    public function getAllEnabled()
    {
        $urls = $this->repository
            ->findBy(array(
                'enabled' => true
            ));

        if (null === $urls) {
            $urls = array();
        }

        return $urls;
    }

    public function getById($id)
    {
        $url = $this->repository
            ->findBy(
                array("id" => $id)
            );

        if (null === $url) {
            $url = null;
        }

        return $url[0];
    }

    public function getByIds(array $ids)
    {
        $urls = null;

        if(count($ids) > 0) {
            $conditionArray = array();

            foreach ($ids as $id) {
                $conditionArray[] .= "url.id=".$id;
            }
            $whereQuery = " WHERE ".implode(" OR ", $conditionArray);

            $urls = $this->em->createQuery("SELECT url FROM ".$this->class." url".$whereQuery)->getResult();
        }

        if (null === $urls) {
            $urls = array();
        }

        return $urls;
    }

    public function getByUrl($url)
    {
        $urls = $this->repository
            ->findBy(
                array("url" => $url)
            );

        if (null === $url || count($urls) == 0) {
            $url = null;
        } else {
            $url = $urls[0];
        }

        return $url;
    }

    public function getByContentId($contentId)
    {
        $urls = $this->repository
            ->findBy(
                array("contentId" => $contentId)
            );

        if (null === $urls || count($urls) == 0) {
            $urls = array();
        }

        return $urls;
    }

    public function save($object)
    {
        if ($object->getEnabled() === null) {
            $object->setEnabled(true);
        }

        $this->em->persist($object);
        $this->em->flush();

        return $object->getId();
    }

    public function disableById($id)
    {
        $url = $this->repository
            ->find($id);

        if ($url->getCanonical() === false) {
            $url->setEnabled(false);

            $this->save($url);
        }
    }

    public function enableById($id)
    {
        $url = $this->repository
            ->find($id);

        $url->setEnabled(true);

        $this->save($url);
    }

    public function setCanonicalById($id)
    {
        $url = $this->repository
            ->find($id);

        $otherUrls = $this->getByContentId($url->getContentId());
        foreach ($otherUrls as $otherUrl) {
            if ($otherUrl->getId() === $url->getId()) {
                $otherUrl->setCanonical(true);
                $this->save($otherUrl);
            } elseif ($otherUrl->getCanonical() !== false) {
                $otherUrl->setCanonical(false);
                $this->save($otherUrl);
            }
        }
    }

    public function create($content, $urlString = null)
    {
        if ($urlString !== null) {
            $generatedUrl = $urlString;
        } else {
            $generatedUrl = $this->generateUrl($content);
        }

        $foundUrl = $this->repository
            ->findBy(
                array('url' => $generatedUrl)
            );

        if (null === $foundUrl || count($foundUrl) == 0) {
            $url = new $this->class();

            $url->setUrl($generatedUrl);

            $url->setContentId($content->getId());
            $url->setCanonical(false);

            $url->setContentType($content->getType());

            $this->save($url);
            $this->setCanonicalById($url->getId());
        }
    }

    public function cleanup()
    {
        $this->em->clear();
    }

    public function generateUrl($content)
    {
        $sectionPart = $this->generateSectionPath($content->getSection());

        $fileName = $this->generateFileName($content);

        $url = $sectionPart."/".$fileName;

        return $url;
    }

    private function generateSectionPath($section)
    {
        if (($sectionId = $section->getParentId()) > 0)
        {
            $parent = $this->sectionManager->getById($sectionId);
            $sectionPath = $this->generateSectionPath($parent);
            $sectionPath .= "/".$section->getSlug();
        } else {
            $sectionPath = "/".$section->getSlug();
        }
        
        return $sectionPath;
    }

    private function generateFileName($content)
    {
        $title = $content->getTitle();
        $publisheDateString = $content->getPublishedDT()->format("YmdHis");

        $excludedWords = array("-que-","-a-","-de-","-del-","-en-","-lo-","-la-","-el-","-los-","-las-","-ellos-","-ellas-");

        $title = $this->normalizeString($title);
        $title = str_replace($excludedWords, "-", "-".$title."-");

        $filename = $title."-".$publisheDateString.".html";
        $filename = str_replace("--", "-", $filename);
        if (substr($filename, 0, 1) == "-") {
            $filename = substr($filename, 1);
        }

        return $filename;
    }

    private function normalizeString($string)
    {
        $a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ', 'Ά', 'ά', 'Έ', 'έ', 'Ό', 'ό', 'Ώ', 'ώ', 'Ί', 'ί', 'ϊ', 'ΐ', 'Ύ', 'ύ', 'ϋ', 'ΰ', 'Ή', 'ή');
        $b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o', 'Α', 'α', 'Ε', 'ε', 'Ο', 'ο', 'Ω', 'ω', 'Ι', 'ι', 'ι', 'ι', 'Υ', 'υ', 'υ', 'υ', 'Η', 'η');

        $result = urldecode($string);
        $result = preg_replace('/(&#[0-9]+;)/',"-",$result);
        $result = str_replace(array("(",")","-"), array(" "," "," "), $result);

        $result = str_replace(array("  ","   ","    ","     ")," ",$result);
        $result = trim ($result);
        $result = str_replace(array("/","'",'"',"´",":","."," ",",",";"),array("-","-","","-","","","-","",""),$result);
        $result = str_replace($a,$b,$result);
        $result = str_replace(array("--","---","----","-----"),"-",$result);
        $result = strtolower($result);
        return $result;
    }
}
