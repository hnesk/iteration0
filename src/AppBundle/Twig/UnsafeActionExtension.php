<?php
/**
 * Created by PhpStorm.
 * User: jk
 * Date: 15.12.14
 * Time: 11:45
 */

namespace AppBundle\Twig;

use AppBundle\Service\UnsafeActionFormBuilder;
use Symfony\Bridge\Twig\Form\TwigRendererInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;

class UnsafeActionExtension extends \Twig_Extension
{
    /** @var FormFactoryInterface */
    private $formBuilder;

    /**
     * @var TwigRendererInterface
     */
    private $renderer;

    public function __construct(UnsafeActionFormBuilder $formBuilder, TwigRendererInterface $renderer)
    {
        $this->formBuilder = $formBuilder;
        $this->renderer = $renderer;
    }

    /**
     * {@inheritdoc}
     */
    public function initRuntime(\Twig_Environment $environment)
    {
        $this->renderer->setEnvironment($environment);
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('unsafe_action', [$this, 'unsafeActionButton'], ['is_safe' => ['html']]),
        );
    }

    public function unsafeActionButton($url, $method = 'DELETE', $label = 'löschen')
    {
        /** @var Form $form */
        $form = $this->formBuilder->form($url, $method, $label);

        return $this->renderer->renderBlock($form->createView(), 'form');
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'unsafe_action';
    }
}
