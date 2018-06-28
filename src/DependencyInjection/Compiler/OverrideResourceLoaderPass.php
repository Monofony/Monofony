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
use App\Routing\ResourceLoader;
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
class OverrideResourceLoaderPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $resourceLoaderDefinition = $container->getDefinition('sylius.routing.loader.resource');
        $resourceLoaderDefinition->setClass(ResourceLoader::class);
    }
}
