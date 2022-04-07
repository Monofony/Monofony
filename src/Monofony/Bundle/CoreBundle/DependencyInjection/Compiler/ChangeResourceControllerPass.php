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

namespace App\Monofony\Bundle\CoreBundle\DependencyInjection\Compiler;

use App\Controller\ResourceController;
use App\Controller\UserController;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController as SyliusResourceController;
use Sylius\Bundle\UserBundle\Controller\UserController as SyliusUserController;
use Sylius\Component\Resource\Metadata\Metadata;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ChangeResourceControllerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {        /** @var array<string, array> $resources */
        $resources = $container->hasParameter('sylius.resources') ? $container->getParameter('sylius.resources') : [];

        foreach ($resources as $alias => $resourceConfig) {
            $metadata = Metadata::fromAliasAndConfiguration($alias, $resourceConfig);
            $controller = $resourceConfig['classes']['controller'];
            $definition = $container->getDefinition($metadata->getServiceId('controller'));

            if (SyliusResourceController::class === $controller) {
                $definition->setClass(ResourceController::class);
                $container->setDefinition($metadata->getServiceId('controller'), $definition);
            }

            if (SyliusUserController::class === $controller) {
                $definition->setClass(UserController::class);
                $container->setDefinition($metadata->getServiceId('controller'), $definition);
            }
        }
    }
}
