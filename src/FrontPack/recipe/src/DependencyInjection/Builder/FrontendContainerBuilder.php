<?php

declare(strict_types=1);

namespace App\DependencyInjection\Builder;

use App\Dashboard\Statistics\StatisticInterface;
use App\DependencyInjection\Compiler\ConfigureDashboardStatisticsProviderPass;
use App\Menu\AccountMenuBuilder;
use App\Menu\AdminMenuBuilder;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class FrontendContainerBuilder
{
    public static function build(ContainerBuilder $container): void
    {
        self::buildAccountMenu($container);
    }

    private static function buildAccountMenu(ContainerBuilder $container): void
    {
        $container->registerForAutoconfiguration(AccountMenuBuilder::class)
            ->addTag('knp_menu.menu_builder', [
                'method' => 'createMenu',
                'alias' => 'app.account',
            ]);
    }
}
