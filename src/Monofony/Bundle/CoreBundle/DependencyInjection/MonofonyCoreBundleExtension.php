<?php

declare(strict_types=1);

namespace App\Monofony\Bundle\CoreBundle\DependencyInjection;

use Doctrine\Common\EventSubscriber;
use Sylius\Component\Customer\Context\CustomerContextInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;

class MonofonyCoreBundleExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $this->tagCustomerContext($container);
        $this->tagDoctrineEventSubscribers($container);
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
