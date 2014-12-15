<?php

namespace AppBundle\Controller;

use Gaufrette\Filesystem;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Service\ControllerUtils;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class StaticController
 * @Route("/", service="app.controller.static")
 */
class StaticController
{
    /** @var ControllerUtils */
    protected $utils;

    /** @var Filesystem*/
    protected $files;


    /**
     * @param ControllerUtils $utils
     * @param Filesystem $files
     */
    public function __construct(ControllerUtils $utils, Filesystem $files)
    {
        $this->utils = $utils;
        $this->files = $files;
    }

    /**
     * @Route("/")
     * @return string
     */
    public function indexAction()
    {
        return $this->utils->redirectRoute('app_static_page', ['page' => 'page']);
    }


    /**
     * @Route("/{page}")
     * @param string $page
     * @return Response
     */
    public function pageAction($page)
    {
        if (!$this->files->has($page)) {
            throw new NotFoundHttpException('Seite "'.$page.'" nicht gefunden!');
        }
        $content = $this->files->read($page);
        return $this->utils->render(
            '@App/Static/index.html.twig',
            [
                'page' => $page,
                'content' => $content
            ]
        );
    }

}
