<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('AppBundle:Default:index.html.twig', array('name' => 'Hannes'));
    }

    /**
     * @Route("/test")
     */
    public function testAction()
    {
        return $this->render('AppBundle:Default:index.html.twig', array('name' => 'Test'));
    }

}
