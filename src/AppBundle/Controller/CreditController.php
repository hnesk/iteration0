<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Credit\Agreement;
use AppBundle\Entity\Credit\AgreementRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Service\ControllerUtils;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * @Route("/direktkredit/planung", service="app.controller.credit")
 */
class CreditController
{
    /** @var ControllerUtils */
    protected $utils;

    /** @var AgreementRepository */
    protected $agreements;

    /**
     * @param ControllerUtils     $utils
     * @param AgreementRepository $agreements
     */
    public function __construct(ControllerUtils $utils, AgreementRepository $agreements)
    {
        $this->utils = $utils;
        $this->agreements = $agreements;
    }

    /**
     * @Route("/")
     * @return string
     */
    public function indexAction()
    {
        return $this->utils->render(
            '@App/Agreement/index.html.twig',
            [
                'agreements' => $this->agreements->findAll(),
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
        $agreement = new Agreement();
        $form = $this->utils->formBuilder('credit_agreement', $agreement)
            ->add('submit', 'submit', ['label' => 'Neuer Direktkreditvertrag'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->agreements->persist($agreement);
        }

        return $this->utils->render(
            '@App/Agreement/new.html.twig',
            [
                'agreement' => $agreement,
                'form' => $form->createView()
            ]
        );
    }

    /**
     * @Route("/{agreement}/")
     * @param  Request   $request
     * @param  Agreement $agreement
     * @return Response
     */
    public function editAction(Request $request, Agreement $agreement)
    {
        $form = $this->utils->formBuilder('credit_agreement', $agreement)
            ->add('submit', 'submit', ['label' => 'Speichern'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->agreements->persist($agreement);
        }

        return $this->utils->render(
            '@App/Agreement/edit.html.twig',
            [
                'agreement' => $agreement,
                'form' => $form->createView()
            ]
        );
    }

    /**
     * @Route("/{agreement}/",methods={"DELETE"})
     * @param  Request   $request
     * @param  Agreement $agreement
     * @return Response
     */
    public function deleteAction(Request $request, Agreement $agreement)
    {
        $form = $this->utils->unsafeActionForm();
        $form->handleRequest($request);
        if ($form->isValid()) {
            $this->agreements->remove($agreement);

            return $this->utils->redirectRoute('app_lender_index');
        }
        throw new BadRequestHttpException('Invalid form');
    }
}
