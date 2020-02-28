<?php

namespace Monofony\Bundle\CoreBundle;

use Monofony\Bundle\CoreBundle\DependencyInjection\Compiler\ChangeCustomerContextVisibilityPass;
use Monofony\Bundle\CoreBundle\DependencyInjection\Compiler\RegisterPasswordListenerForResourcesPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class MonofonyCoreBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new RegisterPasswordListenerForResourcesPass());
        $container->addCompilerPass(new ChangeCustomerContextVisibilityPass());
    }
}
