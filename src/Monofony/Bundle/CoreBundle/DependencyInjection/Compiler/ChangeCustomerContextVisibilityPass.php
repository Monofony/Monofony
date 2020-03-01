<?php

declare(strict_types=1);

namespace Monofony\Bundle\CoreBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class ChangeCustomerContextVisibilityPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        foreach ($container->findTaggedServiceIds('monofony.customer_context') as $serviceId => $attributes) {
            $serviceDefinition = $container->findDefinition($serviceId);

            $serviceDefinition->setPublic(true);
            $serviceDefinition->clearTag('monofony.customer_context');
        }
    }
}
