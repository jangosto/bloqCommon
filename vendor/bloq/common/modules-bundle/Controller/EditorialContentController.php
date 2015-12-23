<?php
namespace Bloq\Common\ModulesBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class EditorialContentController extends Controller
{
    public function outstandingsCarouselAction($limit = 0, $excludedContents = null)
    {
        $editorialContentManager = $this->container->get('editor.editorial_content.manager');

        $editorialContents = $editorialContentManager->getOutstandings($limit, $excludedContents->toArray());

        foreach ($editorialContents as $content) {
            $content = $editorialContentManager->setDataForRepresentation($content);
            $excludedContents->add($content->getId());
        }

        return $this->render('BloqModulesBundle:editorial_content:outstandings_carousel.html.twig', array(
            'user' => $this->getUser(),
            'contents' => $editorialContents
        ));
    }

    public function lastPublishedListTwoColAction($limit = 0, $excludedContents = null)
    {
        $editorialContentManager = $this->container->get('editor.editorial_content.manager');

        $editorialContents = $editorialContentManager->getOrderedByDate($limit, $excludedContents->toArray());
        foreach ($editorialContents as $content) {
            $content = $editorialContentManager->setDataForRepresentation($content);
            $excludedContents->add($content->getId());
        }
        
        return $this->render('BloqModulesBundle:editorial_content:list_two_cols.html.twig', array(
            'user' => $this->getUser(),
            'contents' => $editorialContents
        ));
    }

    public function lastPublishedBySectionListTwoColAction($sectionId, $limit = 0, $excludedContents = null)
    {
        $editorialContentManager = $this->container->get('editor.editorial_content.manager');

        $editorialContents = $editorialContentManager->getOrderedByDate($limit, $excludedContents->toArray(), "AND editorial_content.sectionId = ".$sectionId);
        foreach ($editorialContents as $content) {
            $content = $editorialContentManager->setDataForRepresentation($content);
            $excludedContents->add($content->getId());
        }

        return $this->render('BloqModulesBundle:editorial_content:full_photo_list_two_cols.html.twig', array(
            'user' => $this->getUser(),
            'contents' => $editorialContents,
        ));
    }

    public function inCoverListTwoColAction($title = '', $limit = 0, $excludedContents = null)
    {
        $editorialContentManager = $this->container->get('editor.editorial_content.manager');

        $editorialContents = $editorialContentManager->getOrderedByDate($limit, $excludedContents->toArray());
        foreach ($editorialContents as $content) {
            $content = $editorialContentManager->setDataForRepresentation($content);
            $excludedContents->add($content->getId());
        }

        return $this->render('BloqModulesBundle:editorial_content:editorial_content_list_two_cols_with_intro.html.twig', array(
            'user' => $this->getUser(),
            'title' => $title,
            'contents' => $editorialContents,
        ));
    }

    public function canInterestYouAction($title = '', $limit = 0, $content, $excludedContents = null)
    {
        $editorialContentManager = $this->container->get('editor.editorial_content.manager');
        $urlManager = $this->container->get('editor.url.manager');

        if (count($content->getTags()) > 0) {
            $interestingContents = $editorialContentManager->getBySameTags($content, false, $limit, $excludedContents->toArray());
        } else {
            $interestingContents = array();
        }

        foreach ($interestingContents as $interestingContent) {
            $interestingContent = $editorialContentManager->setDataForRepresentation($interestingContent);
            $excludedContents->add($interestingContent->getId());
        }

        return $this->render('BloqModulesBundle:editorial_content:editorial_content_right_col_interesting_contents.html.twig', array(
            'user' => $this->getUser(),
            'title' => $title,
            'contents' => $interestingContents,
        ));
    }
}
