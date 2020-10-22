<?php

namespace App\Dashboard\Statistics;

use App\Repository\CustomerRepository;
use Monofony\Component\Admin\Dashboard\Statistics\StatisticInterface;
use Symfony\Component\Templating\EngineInterface;

class CustomerStatistic implements StatisticInterface
{
    private $customerRepository;
    private $engine;

    public function __construct(CustomerRepository $customerRepository, EngineInterface $engine)
    {
        $this->customerRepository = $customerRepository;
        $this->engine = $engine;
    }

    public function generate(): string
    {
        $amountCustomers = $this->customerRepository->countCustomers();

        return $this->engine->render('backend/dashboard/statistics/_amount_of_customers.html.twig', [
            'amountOfCustomers' => $amountCustomers,
        ]);
    }

    public static function getDefaultPriority(): int
    {
        return -1;
    }
}
