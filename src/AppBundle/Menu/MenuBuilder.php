<?php
namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;

class MenuBuilder
{
    private $factory;

    /**
     * @param FactoryInterface $factory
     */
    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public function createMainMenu(/*Request $request*/)
    {
        $menu = $this->factory->createItem('root');
        $menu->addChild('Start', ['route' => 'cms_static_index']);
        $we = $menu->addChild('Wer wir sind', ['route' => 'cms_static_page', 'routeParameters' => ['page'=>'wer-wir-sind']]);

        $menu->addChild('Wer wir sind', ['route' => 'cms_static_page', 'routeParameters' => ['page'=>'wer-wir-sind']]);
        return $menu;
    }
}