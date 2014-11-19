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

    public function __construct(ControllerUtils $utils, Filesystem $files) {
        $this->utils = $utils;
        $this->files = $files;
    }

    /**
     * @Route("/{page}")
     * @param string $page
     * @return string
     */
    public function indexAction($page)
    {
        if (!$this->files->has($page)) {
            throw new NotFoundHttpException('Seite "'.$page.'" nicht gefunden!');
        }
        $content = $this->files->read($page);
        return new Response(
            $this->utils->render(
                '@App/Static/index.html.twig',
                [
                    'page' => $page,
                    'content' => $content
                ]
            )
        );
    }


}
