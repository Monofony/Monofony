<?php

declare(strict_types=1);

namespace App\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Monofony\Bundle\FrontBundle\Menu\AccountMenuBuilderInterface;
use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

final class AccountMenuBuilder implements AccountMenuBuilderInterface
{
    public const EVENT_NAME = 'sylius.menu.app.account';

    /** @var FactoryInterface */
    private $factory;

    /** @var EventDispatcherInterface */
    private $eventDispatcher;

    public function __construct(FactoryInterface $factory, EventDispatcherInterface $eventDispatcher)
    {
        $this->factory = $factory;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * {@inheritdoc}
     */
    public function createMenu(array $options): ItemInterface
    {
        $menu = $this->factory->createItem('root');
        $menu->setLabel('sylius.ui.my_account');

        $menu
            ->addChild('dashboard', ['route' => 'sylius_frontend_account_dashboard'])
            ->setLabel('sylius.ui.dashboard')
            ->setLabelAttribute('icon', 'home')
        ;
        $menu
            ->addChild('personal_information', ['route' => 'sylius_frontend_account_profile_update'])
            ->setLabel('sylius.ui.personal_information')
            ->setLabelAttribute('icon', 'user')
        ;
        $menu
            ->addChild('change_password', ['route' => 'sylius_frontend_account_change_password'])
            ->setLabel('sylius.ui.change_password')
            ->setLabelAttribute('icon', 'lock')
        ;

        $this->eventDispatcher->dispatch(new MenuBuilderEvent($this->factory, $menu), self::EVENT_NAME);

        return $menu;
    }
}
