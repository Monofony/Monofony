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

use App\Swagger\AppAuthenticationTokenDocumentationNormalizer;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractCompilerPassTestCase;
use Monofony\Bundle\CoreBundle\DependencyInjection\Compiler\RegisterDocumentationNormalizersPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class RegisterDocumentationNormalizersPassTest extends AbstractCompilerPassTestCase
{
    /** @test */
    public function it_registers_app_authentication_token_documentation_normalizer(): void
    {
        $this->container->register(AppAuthenticationTokenDocumentationNormalizer::class, AppAuthenticationTokenDocumentationNormalizer::class);

        $definition = $this->container->findDefinition(AppAuthenticationTokenDocumentationNormalizer::class);
        $definition->addTag('monofony.documentation_normalizer.app_authentication_token');

        $this->compile();

        $definition = $this->container->findDefinition(AppAuthenticationTokenDocumentationNormalizer::class);

        $this->assertEquals([
            'api_platform.swagger.normalizer.documentation',
            null,
            10,
        ], $definition->getDecoratedService());

        $this->assertEquals(
            AppAuthenticationTokenDocumentationNormalizer::class.'.inner',
            $definition->getArgument(0),
        );
    }

    protected function registerCompilerPass(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new RegisterDocumentationNormalizersPass());
    }
}
