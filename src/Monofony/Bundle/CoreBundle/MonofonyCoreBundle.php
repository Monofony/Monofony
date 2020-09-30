<?php

/*
 * This file is part of the Monofony package.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Monofony\Bundle\CoreBundle;

use Monofony\Bundle\CoreBundle\DependencyInjection\Compiler\ChangeCustomerContextVisibilityPass;
use Monofony\Bundle\CoreBundle\DependencyInjection\Compiler\RegisterPasswordListenerForResourcesPass;
use Monofony\Bundle\CoreBundle\DependencyInjection\MonofonyCoreBundleExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class MonofonyCoreBundle extends Bundle
{
    public const VERSION = '0.3.0-dev';

    public function getContainerExtension()
    {
        return new MonofonyCoreBundleExtension();
    }

    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new RegisterPasswordListenerForResourcesPass());
        $container->addCompilerPass(new ChangeCustomerContextVisibilityPass());
    }
}
