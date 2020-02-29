<?php

declare(strict_types=1);

namespace Monofony\Bundle\AdminBundle;

use App\Monofony\Bundle\AdminBundle\Menu\AdminMenuBuilderInterface;
use Monofony\Bundle\AdminBundle\Dashboard\Statistics\StatisticInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class MonofonyAdminBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        self::buildDashboardServices($container);
        self::buildAdminMenu($container);
    }

    private static function buildDashboardServices(ContainerBuilder $container): void
    {
        $container->registerForAutoconfiguration(StatisticInterface::class)
            ->addTag('app.dashboard_statistic');

        // $container->addCompilerPass(new ConfigureDashboardStatisticsProviderPass());
    }

    private static function buildAdminMenu(ContainerBuilder $container): void
    {
        $container->registerForAutoconfiguration(AdminMenuBuilderInterface::class)
            ->addTag('knp_menu.menu_builder', [
                'method' => 'createMenu',
                'alias' => 'app.admin.main',
            ]);
    }
}
