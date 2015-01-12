<?php

namespace CmsBundle\Controller;

use CmsBundle\Service\PageManager;
use CmsBundle\Service\ControllerUtils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class StaticController
 * @Route("/", service="cms.controller.static")
 */
class StaticController
{
    /** @var ControllerUtils */
    protected $utils;

    /** @var PageManager */
    protected $pageManager;

    /**
     * @param ControllerUtils $utils
     * @param PageManager $pageManager
     */
    public function __construct(ControllerUtils $utils, PageManager $pageManager)
    {
        $this->utils = $utils;
        $this->pageManager = $pageManager;
    }

    /**
     * @Route("/")
     * @return string
     */
    public function indexAction()
    {
        return $this->utils->redirectRoute('cms_static_page', ['page' => $this->pageManager->getHome()->getPath()]);
    }

    /**
     * @Route("/update")
     * @return string
     */
    public function update()
    {
        $this->pageManager->update();
        return $this->utils->redirectRoute('cms_static_index');
    }


    /**
     * @Route("/{page}",requirements={"page":".+"})
     * @param string $page
     * @return Response
     */
    public function pageAction($page)
    {
        $page = $this->pageManager->get($page);
        return $this->utils->render(
            '@Cms/Static/index.html.twig',
            [
                'page' => $page,
            ]
        );
    }

}
