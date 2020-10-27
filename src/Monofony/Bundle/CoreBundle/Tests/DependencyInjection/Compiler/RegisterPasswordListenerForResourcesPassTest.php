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

namespace Monofony\Bundle\CoreBundle\Tests\DependencyInjection\Compiler;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractCompilerPassTestCase;
use Monofony\Bridge\SyliusUser\EventListener\PasswordUpdaterListener;
use Monofony\Bundle\CoreBundle\DependencyInjection\Compiler\RegisterPasswordListenerForResourcesPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

final class RegisterPasswordListenerForResourcesPassTest extends AbstractCompilerPassTestCase
{
    /**
     * @test
     */
    public function it_registers_password_listener_if_listener_is_present(): void
    {
        $this->setDefinition('sylius.listener.password_updater', new Definition());

        $this->compile();

        $this->assertContainerBuilderHasService(
            'sylius.listener.password_updater',
            PasswordUpdaterListener::class
        );
    }

    protected function registerCompilerPass(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new RegisterPasswordListenerForResourcesPass());
    }
}
