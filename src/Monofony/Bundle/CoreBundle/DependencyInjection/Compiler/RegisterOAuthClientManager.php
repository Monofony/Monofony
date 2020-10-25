<?php

/*
 * This file is part of the Monofony package.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Monofony\Bundle\CoreBundle\DependencyInjection\Compiler;

use Monofony\Bridge\FOSOAuthServer\Entity\ClientManager;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class RegisterOAuthClientManager implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (
            !$container->hasParameter('fos_oauth_server.model.client.class')
            || !class_exists(ClientManager::class)
        ) {
            return;
        }

        $container->register(ClientManager::class, '%fos_oauth_server.model.client.class%');
    }
}
