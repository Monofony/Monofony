<?php

/*
 * This file is part of the Monofony package.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Monofony\Bundle\AdminBundle\DependencyInjection;

use Monofony\Bundle\AdminBundle\Dashboard\Statistics\StatisticInterface;
use Monofony\Bundle\AdminBundle\Menu\AdminMenuBuilderInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class MonofonyAdminBundleExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config')
        );
        $loader->load('services.yaml');

        $this->buildDashboardServices($container);
        $this->buildAdminMenu($container);
    }

    private function buildDashboardServices(ContainerBuilder $container): void
    {
        $container->registerForAutoconfiguration(StatisticInterface::class)
            ->addTag('app.dashboard_statistic');
    }

    private function buildAdminMenu(ContainerBuilder $container): void
    {
        $container->registerForAutoconfiguration(AdminMenuBuilderInterface::class)
            ->addTag('knp_menu.menu_builder', [
                'method' => 'createMenu',
                'alias' => 'app.admin.main',
            ]);
    }
}
