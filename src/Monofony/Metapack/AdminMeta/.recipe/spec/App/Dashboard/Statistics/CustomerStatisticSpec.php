<?php

namespace spec\App\Dashboard\Statistics;

use App\Dashboard\Statistics\CustomerStatistic;
use App\Repository\CustomerRepository;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Templating\EngineInterface;
use Twig\Environment;

class CustomerStatisticSpec extends ObjectBehavior
{
    function let(CustomerRepository $customerRepository, Environment $twig): void
    {
        $this->beConstructedWith($customerRepository, $twig);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CustomerStatistic::class);
    }

    function it_generate_statistics(
        CustomerRepository $customerRepository,
        Environment $twig
    ): void {
        $customerRepository->countCustomers()->willReturn(6);

        $twig->render('backend/dashboard/statistics/_amount_of_customers.html.twig', [
            'amountOfCustomers' => 6,
        ])->willReturn('statistics');

        $twig->render('backend/dashboard/statistics/_amount_of_customers.html.twig', [
            'amountOfCustomers' => 6,
        ])->shouldBeCalled();

        $this->generate();
    }
}
