<?php

namespace Bloq\Common\FrontBundle\Twig;

class FrontEditorialContentExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('canonicalUrl', array($this, 'canonicalUrlFilter')),
            new \Twig_SimpleFilter('analyticsSectionString', array($this, 'analyticsSectionStringFilter')),
        );
    }

    public function analyticsSectionStringFilter($section)
    {
        $tempSection = null;

        if (($tempSection = $section->getParent()) != null) {
            $result = $this->analyticsSectionStringFilter($tempSection)." - ".$section->getName();
        } else {
            $result = $section->getName();
        }

        return $result;
    }

    public function canonicalUrlFilter($editorialContent)
    {
        foreach ($editorialContent->getUrls() as $url) {
            if ($url->getCanonical() === true) {
                return $url->getUrl();
            }
        }

        return null;
    }

    public function getName()
    {
        return 'front_editorial_content_extension';
    }
}
