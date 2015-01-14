<?php
/**
 * @author Johannes Künsebeck <jkuensebeck@taz.de>
 *
 */

namespace CmsBundle\Service;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\InvalidParameterException;
use Symfony\Component\Routing\Exception\MissingMandatoryParametersException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\Templating\TemplateReferenceInterface;

/**
 * Class ControllerUtils
 */
class ControllerUtils
{
    /** @var EngineInterface */
    private $templating;

    /** @var FormFactoryInterface */
    private $formFactory;

    /** @var RouterInterface */
    private $router;

    /** @var SecurityContextInterface */
    private $security;

    /**
     * @param EngineInterface          $templating
     * @param RouterInterface          $router
     * @param FormFactoryInterface     $formFactory
     * @param SecurityContextInterface $security
     */
    public function __construct(
        EngineInterface $templating,
        RouterInterface $router,
        FormFactoryInterface $formFactory,
        SecurityContextInterface $security
    ) {
        $this->templating = $templating;
        $this->router = $router;
        $this->formFactory = $formFactory;
        $this->security = $security;
    }

    /**
     * Returns a RedirectResponse to the given URL.
     *
     * @param string $url    The URL to redirect to
     * @param int    $status The status code to use for the Response
     *
     * @return RedirectResponse
     */
    public function redirect($url, $status = Response::HTTP_FOUND)
    {
        return new RedirectResponse($url, $status);
    }

    /**
     * @param  string               $type    #FormType
     * @param  null                 $data
     * @param  array                $options
     * @return FormBuilderInterface
     */
    public function formBuilder($type = 'form', $data = null, array $options = array())
    {
        return $this->formFactory->createBuilder($type, $data, $options);
    }

    /**
     * Generates a URL or path for a specific route based on the given parameters.
     *
     * Parameters that reference placeholders in the route pattern will substitute them in the
     * path or host. Extra params are added as query string to the URL.
     *
     * When the passed reference type cannot be generated for the route because it requires a different
     * host or scheme than the current one, the method will return a more comprehensive reference
     * that includes the required params. For example, when you call this method with $referenceType = ABSOLUTE_PATH
     * but the route requires the https scheme whereas the current scheme is http, it will instead return an
     * ABSOLUTE_URL with the https scheme and the current host. This makes sure the generated URL matches
     * the route in any case.
     *
     * If there is no route with the given name, the generator must throw the RouteNotFoundException.
     *
     * @param string      $name          The name of the #Route
     * @param mixed       $parameters    An array of parameters
     * @param bool|string $referenceType The type of reference to be generated (one of the constants)
     *
     * @return string The generated URL
     *
     * @throws RouteNotFoundException              If the named route doesn't exist
     * @throws MissingMandatoryParametersException When some parameters are missing that are mandatory for the route
     * @throws InvalidParameterException           When a parameter value for a placeholder is not correct because
     *                                             it does not match the requirement
     *
     * @api
     */
    public function url($name, $parameters = array(), $referenceType = RouterInterface::ABSOLUTE_PATH)
    {
        return $this->router->generate($name, $parameters, $referenceType);
    }

    /**
     * @param  string           $name       #Route
     * @param  array            $parameters
     * @param  int              $status
     * @return RedirectResponse
     */
    public function redirectRoute($name, $parameters = array(), $status = Response::HTTP_FOUND)
    {
        $url = $this->url($name, $parameters, RouterInterface::ABSOLUTE_URL);

        return $this->redirect($url, $status);
    }

    /**
     * Renders a template.
     *
     * @param array|string|TemplateReferenceInterface $name       A #Template name or a TemplateReferenceInterface
     * @param array                                   $parameters An array of parameters to pass to the template
     *
     * @param int   $status
     * @param array $headers
     *
     * @return Response The evaluated template as a string
     *
     * @api
     */
    public function render($name, array $parameters = array(), $status = 200, $headers = array())
    {
        $name = is_array($name) ? $name : array($name);
        foreach ($name as $templateName) {
            if ($this->templating->exists($templateName)) {
                return new Response($this->templating->render($templateName, $parameters), $status, $headers);
            }
        }

        throw new \InvalidArgumentException('No Template found, given: '.implode(', ', $name));
    }
}
