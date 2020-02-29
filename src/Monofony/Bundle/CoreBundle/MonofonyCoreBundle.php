<?php

namespace Monofony\Bundle\CoreBundle;

use Monofony\Bundle\CoreBundle\DependencyInjection\Compiler\ChangeCustomerContextVisibilityPass;
use Monofony\Bundle\CoreBundle\DependencyInjection\Compiler\RegisterPasswordListenerForResourcesPass;
use Sylius\Component\Customer\Context\CustomerContextInterface;
use Sylius\Component\User\Canonicalizer\CanonicalizerInterface;
use Sylius\Component\User\Security\Generator\GeneratorInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class MonofonyCoreBundle extends Bundle
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config')
        );
        $loader->load('services.yaml');
    }

    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new RegisterPasswordListenerForResourcesPass());
        $container->addCompilerPass(new ChangeCustomerContextVisibilityPass());
        $container->setAlias(CanonicalizerInterface::class, 'sylius.canonicalizer');
        $container->setAlias(GeneratorInterface::class, 'sylius.app_user.token_generator.email_verification');
    }
}
