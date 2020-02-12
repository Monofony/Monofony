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

use App\Context\CustomerContext;
use App\EventListener\PasswordUpdaterListener;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ServicesPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $this->processFactories($container);
        $this->processRepositories($container);
        $this->processListeners($container);

        $container->setAlias('sylius.context.customer', CustomerContext::class)->setPublic(true);
    }

    /**
     * @param ContainerBuilder $container
     */
    protected function processFactories(ContainerBuilder $container): void
    {
    }

    /**
     * @param ContainerBuilder $container
     */
    protected function processFormTypes(ContainerBuilder $container): void
    {
    }

    /**
     * @param ContainerBuilder $container
     */
    protected function processRepositories(ContainerBuilder $container): void
    {
    }

    /**
     * @param ContainerBuilder $container
     */
    private function processListeners(ContainerBuilder $container): void
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
