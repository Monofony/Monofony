<?php

/*
 * This file is part of the Monofony package.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Monofony\Bundle\CoreBundle\DataCollector;

use App\Kernel;
use Monofony\Bundle\CoreBundle\MonofonyCoreBundle;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;

final class MonofonyDataCollector extends DataCollector
{
    public function __construct(array $bundles)
    {
        $this->data = [
            'version' => MonofonyCoreBundle::VERSION,
            'extensions' => [
                'MonofonyApiBundle' => ['name' => 'API', 'enabled' => false],
                'MonofonyAdminBundle' => ['name' => 'Admin', 'enabled' => false],
                'MonofonyFrontBundle' => ['name' => 'Front', 'enabled' => false],
            ],
        ];

        foreach (array_keys($this->data['extensions']) as $bundleName) {
            if (isset($bundles[$bundleName])) {
                $this->data['extensions'][$bundleName]['enabled'] = true;
            }
        }
    }

    public function getVersion(): string
    {
        return $this->data['version'];
    }

    public function getExtensions(): array
    {
        return $this->data['extensions'];
    }

    /**
     * {@inheritdoc}
     */
    public function collect(Request $request, Response $response, \Exception $exception = null): void
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
        return 'app';
    }
}
