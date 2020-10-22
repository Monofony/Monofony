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

namespace Monofony\Component\Admin\Dashboard;

use Monofony\Component\Admin\Dashboard\Statistics\StatisticInterface;
use Monofony\Contracts\Admin\Dashboard\DashboardStatisticsProviderInterface;

final class DashboardStatisticsProvider implements DashboardStatisticsProviderInterface
{
    private $statistics;

    public function __construct(iterable $statistics)
    {
        $this->statistics = $statistics;
    }

    public function getStatistics(): array
    {
        /** @var string[] $statistics */
        $statistics = [];

        foreach ($this->statistics as $statistic) {
            if (!$statistic instanceof StatisticInterface) {
                throw new \LogicException(sprintf('Class %s must implement %s', get_class($statistic), StatisticInterface::class));
            }

            $statistics[] = $statistic->generate();
        }

        return $statistics;
    }
}
