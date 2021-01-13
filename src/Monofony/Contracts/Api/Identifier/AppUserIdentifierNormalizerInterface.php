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

namespace Monofony\Contracts\Api\Identifier;

use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

interface AppUserIdentifierNormalizerInterface extends DenormalizerInterface
{
    /**
     * {@inheritdoc}
     *
     * @psalm-suppress InvalidReturnType
     * @psalm-suppress InvalidReturnStatement
     */
    public function denormalize($data, $type, $format = null, array $context = []);

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null);
}
