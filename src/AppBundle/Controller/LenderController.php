<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Credit\Lender;
use AppBundle\Entity\Credit\LenderRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Service\ControllerUtils;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * @Route("/direktkredit/geber", service="app.controller.lender")
 */
class LenderController
{
    /** @var ControllerUtils */
    protected $utils;

    /** @var LenderRepository */
    protected $lenders;

    /**
     * @param ControllerUtils  $utils
     * @param LenderRepository $lenders
     */
    public function __construct(ControllerUtils $utils, LenderRepository $lenders)
    {
        $this->utils = $utils;
        $this->lenders = $lenders;
    }

    /**
     * @Route("/")
     * @return string
     */
    public function indexAction()
    {
        return $this->utils->render(
            '@App/Lender/index.html.twig',
            [
                'lenders' => $this->lenders->findAll(),
            ]
        );
    }

    /**
     * @Route("/neu")
     * @param  Request  $request
     * @return Response
     */
    public function newAction(Request $request)
    {
        $lender = new Lender();
        $form = $this->utils->formBuilder('credit_lender', $lender)
            ->add('submit', 'submit', ['label' => 'Neuer Direktkreditgeber'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->lenders->persist($lender);

            return $this->utils->redirectRoute('app_lender_index');
        }

        return $this->utils->render(
            '@App/Lender/new.html.twig',
            [
                'lender' => $lender,
                'form' => $form->createView()
            ]
        );
    }

    /**
     * @Route("/{lender}/", methods={"GET","POST"})
     * @param  Request  $request
     * @param  Lender   $lender
     * @return Response
     */
    public function editAction(Request $request, Lender $lender)
    {
        $form = $this->utils->formBuilder('credit_lender', $lender)
            ->add('submit', 'submit', ['label' => 'Speichern'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->lenders->persist($lender);

            return $this->utils->redirectRoute('app_lender_index');
        }

        return $this->utils->render(
            '@App/Lender/edit.html.twig',
            [
                'lender' => $lender,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/{lender}/",methods={"DELETE"})
     * @param  Request  $request
     * @param  Lender   $lender
     * @return Response
     *
     */
    public function deleteAction(Request $request, Lender $lender)
    {
        $form = $this->utils->unsafeActionForm();
        $form->handleRequest($request);
        if ($form->isValid()) {
            $this->lenders->remove($lender);

            return $this->utils->redirectRoute('app_lender_index');
        }
        throw new BadRequestHttpException('Invalid form');
    }
}
