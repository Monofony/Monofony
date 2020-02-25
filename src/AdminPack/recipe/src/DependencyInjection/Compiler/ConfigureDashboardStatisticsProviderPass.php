<?php

declare(strict_types=1);

namespace App\DependencyInjection\Compiler;

use App\Dashboard\DashboardStatisticsProvider;
use Symfony\Component\DependencyInjection\Argument\TaggedIteratorArgument;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class ConfigureDashboardStatisticsProviderPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $container->getDefinition(DashboardStatisticsProvider::class)
            ->addArgument(new TaggedIteratorArgument('app.dashboard_statistic'));
    }
}

