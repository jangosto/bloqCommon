<?php

namespace Bloq\Common\FrontBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ComponentsController extends Controller
{
    /**
     * @Route("/radio.html", name="front_radio_player")
     */
    public function radioAction()
    {
        return $this->render('external_components/radio.html.twig', array());
    }
}
