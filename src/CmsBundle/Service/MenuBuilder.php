<?php
namespace CmsBundle\Service;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;

class MenuBuilder
{
    /** @var FactoryInterface  */
    private $factory;

    /** @var PageManager */
    private $pageManager;

    /**
     * @param FactoryInterface $factory
     * @param PageManager      $pageManager
     */
    public function __construct(FactoryInterface $factory, PageManager $pageManager)
    {
        $this->factory = $factory;
        $this->pageManager = $pageManager;
    }

    public function createMainMenu(/*Request $request*/)
    {
        $menu = $this->factory->createItem('root');
        $this->addCmsPage($menu, 'Start', $this->pageManager->getHome()->getPath());

        return $menu;
    }

    public function addCmsPage(ItemInterface $menu, $title, $path)
    {
        return $menu->addChild(
            $title,
            [
                'route' => 'cms_static_page',
                'routeParameters' => [
                    'page' => $path,
                ]
            ]
        );
    }
}
