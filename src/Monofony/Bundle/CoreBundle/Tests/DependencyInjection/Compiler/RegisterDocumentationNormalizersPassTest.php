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
    /**
     * @test
     */
    public function it_registers_app_authentication_token_documentation_normalizer(): void
    {
        $this->compile();

        $this->assertContainerBuilderHasService(
            AppAuthenticationTokenDocumentationNormalizer::class,
            AppAuthenticationTokenDocumentationNormalizer::class
        );
    }

    protected function registerCompilerPass(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new RegisterDocumentationNormalizersPass());
    }
}
