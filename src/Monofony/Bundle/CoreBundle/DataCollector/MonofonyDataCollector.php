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

namespace Monofony\Bundle\CoreBundle\DataCollector;

use Monofony\Bundle\CoreBundle\MonofonyCoreBundle;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;

final class MonofonyDataCollector extends DataCollector
{
    public function __construct()
    {
        $this->data = [
            'version' => MonofonyCoreBundle::VERSION,
        ];
    }

    public function getVersion(): string
    {
        return $this->data['version'];
    }

    /**
     * {@inheritdoc}
     */
    public function collect(Request $request, Response $response, \Throwable $exception = null): void
    {
    }

    /**
     * {@inheritdoc}
     */
    public function reset(): void
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'monofony';
    }
}
