<?php

/*
 * This file is part of monofony.
 *
 * (c) Mobizel
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Dashboard;

use App\Dashboard\Statistics\StatisticInterface;
use Webmozart\Assert\Assert;

class DashboardStatisticsProvider
{
    /**
     * @var StatisticInterface[]
     */
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
