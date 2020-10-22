<?php

namespace App\Monofony\Bundle\CoreBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class RegisterDashboardStatisticsPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('monofony.admin.dashboard_statistics_provider')) {
            return;
        }

        $definition = $container->findDefinition('monofony.admin.dashboard_statistics_provider');
        $taggedServices = $container->findTaggedServiceIds('monofony.dashboard_statistic');

        $arguments = [];

        foreach ($taggedServices as $id => $tags) {
            // add the dashboard statistic to the provider
            $arguments[] = new Reference($id);
        }

        $definition->setArguments([$arguments]);
    }
}
