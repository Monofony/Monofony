<?php

declare(strict_types=1);

namespace Monofony\Bundle\CoreBundle\DependencyInjection\Compiler;

use App\Context\CustomerContext;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class ChangeCustomerContextVisibilityPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (class_exists(CustomerContext::class)) {
            $container->getDefinition(CustomerContext::class)->setPublic(true);
        }
    }
}
