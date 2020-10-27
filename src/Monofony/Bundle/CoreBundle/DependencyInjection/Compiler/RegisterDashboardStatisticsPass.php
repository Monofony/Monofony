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

namespace Monofony\Bundle\CoreBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class RegisterDashboardStatisticsPass implements CompilerPassInterface
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
