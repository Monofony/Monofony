<?php

declare(strict_types=1);

namespace App\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Monofony\Component\Admin\Menu\AdminMenuBuilderInterface;

final class AdminMenuBuilder implements AdminMenuBuilderInterface
{
    public function __construct(private FactoryInterface $factory)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function createMenu(array $options): ItemInterface
    {
        $menu = $this->factory->createItem('root');

        $this->addCustomerSubMenu($menu);
        $this->addConfigurationSubMenu($menu);

        return $menu;
    }

    private function addCustomerSubMenu(ItemInterface $menu): ItemInterface
    {
        $customer = $menu
            ->addChild('customer')
            ->setLabel('sylius.ui.customer')
        ;

        $customer->addChild('backend_customer', ['route' => 'sylius_backend_customer_index'])
            ->setLabel('sylius.ui.customers')
            ->setLabelAttribute('icon', 'users');

        return $customer;
    }

    private function addConfigurationSubMenu(ItemInterface $menu): ItemInterface
    {
        $configuration = $menu
            ->addChild('configuration')
            ->setLabel('sylius.ui.configuration')
        ;

        $configuration->addChild('backend_admin_user', ['route' => 'sylius_backend_admin_user_index'])
            ->setLabel('sylius.ui.admin_users')
            ->setLabelAttribute('icon', 'lock');

        return $configuration;
    }
}
