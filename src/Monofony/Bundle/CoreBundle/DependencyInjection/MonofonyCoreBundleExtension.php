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

namespace Monofony\Bundle\CoreBundle\DependencyInjection;

use Doctrine\Common\EventSubscriber;
use Sylius\Component\Customer\Context\CustomerContextInterface;
use Sylius\Component\User\Canonicalizer\CanonicalizerInterface;
use Sylius\Component\User\Security\Generator\GeneratorInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class MonofonyCoreBundleExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config')
        );
        $loader->load('services.yaml');

        $this->registerSomeSyliusAliases($container);
        $this->tagCustomerContext($container);
        $this->tagDoctrineEventSubscribers($container);
    }

    private function registerSomeSyliusAliases(ContainerBuilder $container): void
    {
        $container->setAlias(CanonicalizerInterface::class, 'sylius.canonicalizer');
        $container->setAlias(GeneratorInterface::class, 'sylius.app_user.token_generator.email_verification');
    }

    private function tagCustomerContext(ContainerBuilder $container): void
    {
        $container->registerForAutoconfiguration(CustomerContextInterface::class)
            ->addTag('monofony.customer_context');
    }

    private function tagDoctrineEventSubscribers(ContainerBuilder $container): void
    {
        $container->registerForAutoconfiguration(EventSubscriber::class)
            ->addTag('doctrine.event_subscriber');
    }
}
