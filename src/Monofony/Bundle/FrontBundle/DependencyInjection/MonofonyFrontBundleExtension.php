<?php

namespace Monofony\Bundle\FrontBundle\DependencyInjection;

use Monofony\Bundle\FrontBundle\Menu\AccountMenuBuilderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;

class MonofonyFrontBundleExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $this->buildAccountMenu($container);
    }

    private function buildAccountMenu(ContainerBuilder $container): void
    {
        $container->registerForAutoconfiguration(AccountMenuBuilderInterface::class)
            ->addTag('knp_menu.menu_builder', [
                'method' => 'createMenu',
                'alias' => 'app.account',
            ]);
    }
}
