<?php

namespace spec\App\Dashboard;

use App\Dashboard\DashboardStatistics;
use App\Dashboard\DashboardStatisticsProvider;
use App\Repository\CustomerRepository;
use PhpSpec\ObjectBehavior;

class DashboardStatisticsProviderSpec extends ObjectBehavior
{
    function let(CustomerRepository $customerRepository): void
    {
        $this->beConstructedWith($customerRepository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(DashboardStatisticsProvider::class);
    }

    function it_obtains_statistics(
        CustomerRepository $customerRepository
    ): void {
        $expectedStats = new DashboardStatistics(6);

        $customerRepository->countCustomers()->willReturn(6);

        $this->getStatistics()->shouldBeLike($expectedStats);
    }
}
