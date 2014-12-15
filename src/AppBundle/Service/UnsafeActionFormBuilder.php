<?php
/**
 * Created by PhpStorm.
 * User: jk
 * Date: 15.12.14
 * Time: 12:45
 */

namespace AppBundle\Service;


use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;

class UnsafeActionFormBuilder {

    /** @var FormFactoryInterface */
    private $formFactory;


    public function __construct(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    /**
     * @param string $url
     * @param string $method
     * @param string $label
     * @return Form
     */
    public function form($url = '', $method = 'DELETE', $label = 'löschen')
    {
        /** @noinspection PhpUndefinedMethodInspection */
        return $this->formFactory->createBuilder()
            ->add('submit','submit', ['label' =>  $label])
            ->setMethod($method)
            ->setAction($url)
            ->getForm();
    }


}

