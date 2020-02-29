<?php

declare(strict_types=1);

namespace App\DependencyInjection\Builder;

use App\DependencyInjection\Compiler\ConfigureDashboardStatisticsProviderPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class BackendContainerBuilder
{
    public static function build(ContainerBuilder $container): void
    {
        self::buildDashboardServices($container);
    }

    private static function buildDashboardServices(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new ConfigureDashboardStatisticsProviderPass());
    }
}
