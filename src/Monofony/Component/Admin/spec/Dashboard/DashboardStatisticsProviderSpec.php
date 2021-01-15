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

namespace spec\Monofony\Component\Admin\Dashboard;

use Monofony\Component\Admin\Dashboard\DashboardStatisticsProvider;
use Monofony\Component\Admin\Dashboard\Statistics\StatisticInterface;
use PhpSpec\ObjectBehavior;

class DashboardStatisticsProviderSpec extends ObjectBehavior
{
    function let(StatisticInterface $firstStatistic, StatisticInterface $secondStatistic): void
    {
        $this->beConstructedWith([$firstStatistic, $secondStatistic]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(DashboardStatisticsProvider::class);
    }

    function it_generate_statistics_for_each_providers(
        StatisticInterface $firstStatistic, StatisticInterface $secondStatistic
    ): void {
        $firstStatistic->generate()->shouldBeCalled();
        $secondStatistic->generate()->shouldBeCalled();

        $this->getStatistics();
    }

    function it_throws_an_invalid_argument_exception_when_statistic_provider_does_not_implements_the_interface(
        \stdClass $statistic
    ): void {
        $this->beConstructedWith([$statistic]);

        $this->shouldThrow(\LogicException::class)->during('getStatistics');
    }
}
