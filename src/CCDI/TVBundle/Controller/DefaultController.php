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
        
        $pages = $this->getDoctrine()->getRepository("ApplicationSonataPageBundle:Page")->findAllPublicPages();
        
        //$this->renderView($view);
        return array('pages' => $pages, 'officeOnly' => false);
    }
    
    /**
     * @Route("/tv/office")
     * @Template()
     */
    public function officeAction()
    {
        $pages = $this->getDoctrine()->getRepository("ApplicationSonataPageBundle:Page")->findBy(array('enabled' => true));


        return array('pages' => $pages, 'officeOnly' => true);



    }
}