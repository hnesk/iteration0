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

        $menu->addChild('Home', ['route' => 'app_static_index']);

        return $menu;
    }
}