<?php

namespace spec\App\Dashboard;

use App\Dashboard\DashboardStatistics;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DashboardStatisticsSpec extends ObjectBehavior
{
    function let(): void
    {
        $this->beConstructedWith(10);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(DashboardStatistics::class);
    }

    function it_has_new_customers_stat(): void
    {
        $this->getNumberOfNewCustomers()->shouldReturn(10);
    }
}
