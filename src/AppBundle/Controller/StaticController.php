<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Credit\Agreement;
use AppBundle\Entity\Credit\AgreementRepository;
use AppBundle\Entity\Credit\Lender;
use AppBundle\Entity\Credit\LenderRepository;
use Gaufrette\Filesystem;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Service\ControllerUtils;
use Symfony\Component\HttpFoundation\Request;
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

    /** @var LenderRepository */
    protected $lenders;

    /** @var AgreementRepository */
    protected $agreements;


    /**
     * @param ControllerUtils $utils
     * @param Filesystem $files
     * @param LenderRepository $lenders
     * @param AgreementRepository $agreements
     */
    public function __construct(ControllerUtils $utils, Filesystem $files, LenderRepository $lenders, AgreementRepository $agreements)
    {
        $this->utils = $utils;
        $this->files = $files;
        $this->lenders = $lenders;
        $this->agreements = $agreements;
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

    /**
     * @Route("/lender/new")
     * @param Request $request
     * @return Response
     */
    public function newLenderAction(Request $request)
    {
        $lender = new Lender();
        $form = $this->utils->formBuilder('credit_lender', $lender)
            ->add('submit','submit', ['label' => 'Neuer Direktkreditgeber'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->lenders->persist($lender);
        }
        return new Response(
            $this->utils->render(
                '@App/Static/newLender.html.twig',
                [
                    'lender' => $lender,
                    'form' => $form->createView()
                ]
            )
        );
    }

    /**
     * @Route("/agreement/new")
     * @param Request $request
     * @return Response
     */
    public function newAgreementAction(Request $request)
    {
        $agreement = new Agreement();
        $form = $this->utils->formBuilder('credit_agreement', $agreement)
            ->add('submit','submit', ['label' => 'Neuer Direktkreditvertrag'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->agreements->persist($agreement);
        }
        return new Response(
            $this->utils->render(
                '@App/Static/newAgreement.html.twig',
                [
                    'agreement' => $agreement,
                    'form' => $form->createView()
                ]
            )
        );
    }

}
