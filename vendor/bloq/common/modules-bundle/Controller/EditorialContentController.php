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

    public function outstandingForCategoryAction($category, $excludedContents = null)
    {
        $editorialContentManager = $this->container->get('editor.editorial_content.manager');

        $editorialContents = $editorialContentManager->getOutstandings(1, $excludedContents->toArray(), "AND editorial_content.sectionId = '".$category->getId()."'");

        if ($editorialContents == null || count($editorialContents) == 0) {
            $editorialContents = $editorialContentManager->getOrderedByDate(1, $excludedContents->toArray(), "AND editorial_content.sectionId = '".$category->getId()."'");
        }

        if ($editorialContents !== null && count($editorialContents) > 0) {
            $editorialContent = $editorialContents[0];
            $editorialContent = $editorialContentManager->setDataForRepresentation($editorialContent);
            $excludedContents->add($editorialContent->getId());
        } else {
            $editorialContent = null;
        }

        return $this->render('BloqModulesBundle:editorial_content:outstanding_editorial_content.html.twig', array(
            'user' => $this->getUser(),
            'content' => $editorialContent
        ));
    }

    public function lastPublishedListTwoColAction($limit = 0, $excludedContents = null, $category = null, $tag = null)
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

    public function lastPublishedByCategoryListTwoColAction($limit = 0, $excludedContents = null, $category = null)
    {
        $editorialContentManager = $this->container->get('editor.editorial_content.manager');

        if ($category != null && is_numeric($category->getId())) {
            $editorialContents = $editorialContentManager->getByCategoryIds(array($category->getId()), $limit, $excludedContents->toArray());
        } else {
            $editorialContents = array();
        }

        foreach ($editorialContents as $content) {
            $content = $editorialContentManager->setDataForRepresentation($content);
            $excludedContents->add($content->getId());
        }

        return $this->render('BloqModulesBundle:editorial_content:list_two_cols.html.twig', array(
            'user' => $this->getUser(),
            'contents' => $editorialContents
        ));
    }

    public function lastPublishedBySectionFullPhotoListTwoColAction($sectionId, $limit = 0, $excludedContents = null)
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

    public function inCoverZoneBListOneColAction($title = '', $limit = 0, $excludedContents = null)
    {
        $editorialContentManager = $this->container->get('editor.editorial_content.manager');

        $editorialContents = $editorialContentManager->getOrderedByDate($limit, $excludedContents->toArray());
        foreach ($editorialContents as $content) {
            $content = $editorialContentManager->setDataForRepresentation($content);
            $excludedContents->add($content->getId());
        }

        return $this->render('BloqModulesBundle:editorial_content:editorial_content_zone_b_list_one_col.html.twig', array(
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

    public function navigationMenuAction()
    {
        $categoryManager = $this->container->get('editor.category.manager');

        $menu = $categoryManager->getMenuAdded();

        return $this->render('BloqModulesBundle:site_tools:navigation_menu.html.twig', array(
            'user' => $this->getUser(),
            'menu' => $menu,
        ));
    }

    public function footerNavigationMenuAction()
    {
        $categoryManager = $this->container->get('editor.category.manager');

        $menu = $categoryManager->getMenuAdded();

        return $this->render('BloqModulesBundle:site_tools:navigation_menu_footer.html.twig', array(
            'user' => $this->getUser(),
            'menu' => $menu,
        ));
    }


}
