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

namespace Monofony\Bundle\CoreBundle\DependencyInjection\Compiler;

use App\Swagger\AppAuthenticationTokenDocumentationNormalizer;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class RegisterDocumentationNormalizersPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!class_exists(AppAuthenticationTokenDocumentationNormalizer::class)) {
            return;
        }

        $normalizerDefinition = $container->register(AppAuthenticationTokenDocumentationNormalizer::class, AppAuthenticationTokenDocumentationNormalizer::class);
        $normalizerDefinition
            ->setDecoratedService('api_platform.swagger.normalizer.documentation', null, 10)
            ->addArgument(new Reference(AppAuthenticationTokenDocumentationNormalizer::class.'.inner'))
        ;
    }
}
