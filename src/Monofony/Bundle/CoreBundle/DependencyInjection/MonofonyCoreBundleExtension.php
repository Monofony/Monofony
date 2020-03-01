<?php

declare(strict_types=1);

namespace Monofony\Bundle\CoreBundle\DependencyInjection;

use Doctrine\Common\EventSubscriber;
use Sylius\Component\Customer\Context\CustomerContextInterface;
use Sylius\Component\User\Canonicalizer\CanonicalizerInterface;
use Sylius\Component\User\Security\Generator\GeneratorInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;

class MonofonyCoreBundleExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
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
