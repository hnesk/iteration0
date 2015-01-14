<?php
namespace CmsBundle\Service;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\Routing\RouterInterface;

class MenuBuilder
{
    /** @var FactoryInterface  */
    private $factory;

    /** @var PageManager */
    private $pageManager;

    /** @var RouterInterface */
    private $router;

    /**
     * @param FactoryInterface $factory
     * @param PageManager      $pageManager
     * @param RouterInterface  $router
     */
    public function __construct(FactoryInterface $factory, PageManager $pageManager, RouterInterface $router)
    {
        $this->factory = $factory;
        $this->pageManager = $pageManager;
        $this->router = $router;
    }

    public function createMainMenu(/*Request $request*/)
    {
        $menuDocument = $this->pageManager->getMenu('main');
        $menu = $this->factory->createItem('root');
        $this->processListItem($menu, $menuDocument, $menuDocument);

        return $menu;
    }

    protected function processListItem(ItemInterface $menu, \DOMDocument $doc, \DOMNode $contextNode)
    {
        $xpath = new \DOMXPath($doc);
        foreach ($xpath->query('ul/li', $contextNode) as $listItem) {
            /** @var \DOMNode $listItem */
            $text = $xpath->evaluate('string(a)', $listItem);
            $link = $xpath->evaluate('string(a/@href)', $listItem);
            $link = preg_replace('#^/.+\.php/#', '/', $link);
            $parameters = $this->router->match($link);
            $childMenu = $menu->addChild(
                $text, [
                    'route' => $parameters['_route'],
                    'routeParameters' => array_diff_key($parameters, ['_route' => true, '_controller' => true])
                ]
            );
            $this->processListItem($childMenu, $doc, $listItem);
        }
    }
}
