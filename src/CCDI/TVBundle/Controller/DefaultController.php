<?php

namespace CCDI\TVBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/tv/")
     * @Template()
     */
    public function indexAction()
    {
        $pages = array();
        
        $pages = $this->getDoctrine()->getRepository("ApplicationSonataPageBundle:Page")->findBy(array('enabled' => true));
        
        //$this->renderView($view);
        return array('pages' => $pages);
    }
    
    /**
     * @Route("/tv/office")
     * @Template()
     */
    public function officeAction()
    {
        $pages = array();
        $this->renderView($view);
        
        
        return array('pages' => $pages);
    }
}