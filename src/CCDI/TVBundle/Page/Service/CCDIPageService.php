<?php

namespace CCDI\TVBundle\Page\Service;

use Sonata\PageBundle\Model\PageInterface;
use Sonata\PageBundle\Page\Service\BasePageService;
use Sonata\PageBundle\Page\Service\PageServiceInterface;
use Sonata\PageBundle\Page\TemplateManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CCDIPageService extends BasePageService implements PageServiceInterface {

    public function __construct($name, TemplateManager $templateManager)
    {
        parent::__construct($name);
        $this->templateManager = $templateManager;
    }


    /**
     * Executes the page. This method acts as a controller's action for a specific page and is therefor expected
     * to return a Response object.
     *
     * @param PageInterface $page Page to execute
     * @param Request $request Request object
     * @param array $parameters An array of view parameters. In the case of hybrid pages, it may have a
     *                                  parameter "content" that contains the view result of the controller.
     * @param Response|null $response Response object
     *
     * @return Response
     */
    public function execute(PageInterface $page, Request $request, array $parameters = array(), Response $response = null)
    {
        // add custom processing (load data, update SEO values, update http headers, perform security checks, ...)
        $officeOnly =  $request->query->get('office');

        return $this->templateManager->renderResponse($page->getTemplateCode(), array('office' => $officeOnly), $response);
    }

} 