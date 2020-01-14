<?php

namespace spec\App\Dashboard\Statistics;

use App\Dashboard\Statistics\CustomerStatistic;
use App\Repository\CustomerRepository;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Templating\EngineInterface;

class CustomerStatisticSpec extends ObjectBehavior
{
    function let(CustomerRepository $customerRepository, EngineInterface $engine): void
    {
        $this->beConstructedWith($customerRepository, $engine);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CustomerStatistic::class);
    }

    function it_generate_statistics(
        CustomerRepository $customerRepository,
        EngineInterface $engine
    ): void {
        $customerRepository->countCustomers()->willReturn(6);

        $engine->render('backend/dashboard/statistics/_amount_of_customers.html.twig', [
            'amountOfCustomers' => 6,
        ])->willReturn('statistics');

        $engine->render('backend/dashboard/statistics/_amount_of_customers.html.twig', [
            'amountOfCustomers' => 6,
        ])->shouldBeCalled();

        $this->generate();
    }
}
