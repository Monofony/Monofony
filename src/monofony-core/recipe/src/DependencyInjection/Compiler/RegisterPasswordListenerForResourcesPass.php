<?php

/*
 * This file is part of AppName.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\DependencyInjection\Compiler;

use App\EventListener\PasswordUpdaterListener;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class RegisterPasswordListenerForResourcesPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
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
