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

use FOS\OAuthServerBundle\Entity\Client;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractCompilerPassTestCase;
use Monofony\Bridge\FOSOAuthServer\Entity\ClientManager;
use Monofony\Bundle\CoreBundle\DependencyInjection\Compiler\RegisterOAuthClientManager;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class RegisterOAuthClientManagerTest extends AbstractCompilerPassTestCase
{
    /**
     * @test
     */
    public function it_registers_client_manager_if_not_oauth_is_configured(): void
    {
        $this->setParameter('fos_oauth_server.model.client.class', new Client());

        $this->compile();

        $this->assertContainerBuilderHasService(
            'monofony.client_manager',
            ClientManager::class
        );
    }

    protected function registerCompilerPass(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new RegisterOAuthClientManager());
    }
}
