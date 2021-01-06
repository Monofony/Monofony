<?php

/*
 * This file is part of the Monofony package.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Monofony\Bundle\CoreBundle\DependencyInjection\Compiler;

use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class RegisterObjectManagerAliasPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container): void
    {
        if (!interface_exists(ObjectManager::class)) {
            return;
        }

        if (!$container->hasDefinition(ObjectManager::class)) {
            $container->setAlias(ObjectManager::class, 'doctrine.orm.default_entity_manager');
        }
    }
}
