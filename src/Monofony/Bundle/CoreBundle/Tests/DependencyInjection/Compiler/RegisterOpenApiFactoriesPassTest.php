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

namespace App\Monofony\Bundle\CoreBundle\Tests\DependencyInjection\Compiler;

use App\OpenApi\Factory\AppAuthenticationTokenOpenOpenApiFactory;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractCompilerPassTestCase;
use Monofony\Bundle\CoreBundle\DependencyInjection\Compiler\RegisterOpenApiFactoriesPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class RegisterOpenApiFactoriesPassTest extends AbstractCompilerPassTestCase
{
    /** @test */
    public function it_registers_app_authentication_token_documentation_normalizer(): void
    {
        $this->container->register(AppAuthenticationTokenOpenOpenApiFactory::class, AppAuthenticationTokenOpenOpenApiFactory::class);

        $definition = $this->container->findDefinition(AppAuthenticationTokenOpenOpenApiFactory::class);
        $definition->addTag('monofony.openapi.factory.app_authentication_token');

        $this->compile();

        $definition = $this->container->findDefinition(AppAuthenticationTokenOpenOpenApiFactory::class);

        $this->assertEquals([
            'api_platform.openapi.factory',
            null,
            -10,
        ], $definition->getDecoratedService());

        $this->assertEquals(
            AppAuthenticationTokenOpenOpenApiFactory::class.'.inner',
            $definition->getArgument(0),
        );
    }

    protected function registerCompilerPass(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new RegisterOpenApiFactoriesPass());
    }
}
