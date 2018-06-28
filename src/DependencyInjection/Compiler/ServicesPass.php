<?php

/*
 * This file is part of Alceane.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\DependencyInjection\Compiler;

use App\EventListener\PasswordUpdaterListener;
use Symfony\Component\Config\Resource\DirectoryResource;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Parameter;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\Finder\Finder;

/**
 * @author Loïc Frémont <loic@mobizel.com>
 */
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
    }

    /**
     * @param ContainerBuilder $container
     */
    protected function processFactories(ContainerBuilder $container)
    {
    }

    /**
     * @param ContainerBuilder $container
     */
    protected function processFormTypes(ContainerBuilder $container)
    {
    }

    /**
     * @param ContainerBuilder $container
     */
    protected function processRepositories(ContainerBuilder $container)
    {
    }

    /**
     * @param ContainerBuilder $container
     */
    private function processListeners(ContainerBuilder $container)
    {
        $listenerPasswordUpdaterDefinition = $container->getDefinition('sylius.listener.password_updater');
        $listenerPasswordUpdaterDefinition
            ->setClass(PasswordUpdaterListener::class)
            ->addTag('kernel.event_listener', [
                'event' => 'sylius.customer.pre_update',
                'method' => 'customerUpdateEvent'
            ])
            ->addTag('kernel.event_listener', [
                'event' => 'sylius.admin_user.pre_update',
                'method' => 'genericEventUpdater'
            ]);
    }
}
