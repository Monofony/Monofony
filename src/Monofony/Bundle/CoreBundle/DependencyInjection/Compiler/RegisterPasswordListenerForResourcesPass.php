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

use Monofony\Bridge\SyliusUser\EventListener\PasswordUpdaterListener;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class RegisterPasswordListenerForResourcesPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container): void
    {
        if (!class_exists(PasswordUpdaterListener::class)) {
            return;
        }

        $listenerPasswordUpdaterDefinition = $container->getDefinition('sylius.listener.password_updater');
        $listenerPasswordUpdaterDefinition
            ->setClass(PasswordUpdaterListener::class)
            ->addTag('kernel.event_listener', [
                'event' => 'sylius.customer.pre_update',
                'method' => 'customerUpdateEvent',
            ])
            ->addTag('kernel.event_listener', [
                'event' => 'sylius.admin_user.pre_update',
                'method' => 'genericEventUpdater',
            ]);
    }
}
