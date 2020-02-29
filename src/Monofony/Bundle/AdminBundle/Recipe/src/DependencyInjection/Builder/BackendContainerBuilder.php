<?php

declare(strict_types=1);

namespace App\DependencyInjection\Builder;

use App\Dashboard\Statistics\StatisticInterface;
use App\DependencyInjection\Compiler\ConfigureDashboardStatisticsProviderPass;
use App\Menu\AdminMenuBuilder;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class BackendContainerBuilder
{
    public static function build(ContainerBuilder $container): void
    {
        self::buildDashboardServices($container);
        self::buildAdminMenu($container);
    }

    private static function buildDashboardServices(ContainerBuilder $container): void
    {
        $container->registerForAutoconfiguration(StatisticInterface::class)
            ->addTag('app.dashboard_statistic');

        $container->addCompilerPass(new ConfigureDashboardStatisticsProviderPass());
    }

    private static function buildAdminMenu(ContainerBuilder $container): void
    {
        $container->registerForAutoconfiguration(AdminMenuBuilder::class)
            ->addTag('knp_menu.menu_builder', [
                'method' => 'createMenu',
                'alias' => 'app.admin.main',
            ]);
    }
}
