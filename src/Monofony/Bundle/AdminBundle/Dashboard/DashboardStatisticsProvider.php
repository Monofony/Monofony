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

namespace Monofony\Bundle\AdminBundle\Dashboard;

use Monofony\Bundle\AdminBundle\Dashboard\Statistics\StatisticInterface;
use Webmozart\Assert\Assert;

final class DashboardStatisticsProvider implements DashboardStatisticsProviderInterface
{
    /** @var iterable&StatisticInterface[] */
    private $statistics;

    public function __construct(iterable $statistics)
    {
        $this->statistics = $statistics;
    }

    public function getStatistics(): array
    {
        $statistics = [];
        foreach ($this->statistics as $statistic) {
            Assert::implementsInterface($statistic, StatisticInterface::class, sprintf('Class %s must implement %s', get_class($statistic), StatisticInterface::class));
            $statistics[] = $statistic->generate();
        }

        return $statistics;
    }
}
