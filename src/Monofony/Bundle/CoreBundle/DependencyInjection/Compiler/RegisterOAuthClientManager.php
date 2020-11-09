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

use Monofony\Bridge\FOSOAuthServer\Entity\ClientManager;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Parameter;
use Symfony\Component\DependencyInjection\Reference;

final class RegisterOAuthClientManager implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (
            !$container->hasParameter('fos_oauth_server.model.client.class')
            || !class_exists(ClientManager::class)
        ) {
            return;
        }

        $definition = $container->register('monofony.client_manager', ClientManager::class);
        $definition
            ->setArguments([
                new Reference('doctrine.orm.entity_manager'),
                new Parameter('fos_oauth_server.model.client.class'),
            ]);
    }
}
