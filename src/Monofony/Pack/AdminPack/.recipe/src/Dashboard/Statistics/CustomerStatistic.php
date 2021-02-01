<?php

declare(strict_types=1);

namespace App\Dashboard\Statistics;

use App\Repository\CustomerRepository;
use Monofony\Component\Admin\Dashboard\Statistics\StatisticInterface;
use Twig\Environment;

class CustomerStatistic implements StatisticInterface
{
    private $customerRepository;
    private $twig;

    public function __construct(CustomerRepository $customerRepository, Environment $twig)
    {
        $this->customerRepository = $customerRepository;
        $this->twig = $twig;
    }

    public function generate(): string
    {
        $amountCustomers = $this->customerRepository->countCustomers();

        return $this->twig->render('backend/dashboard/statistics/_amount_of_customers.html.twig', [
            'amountOfCustomers' => $amountCustomers,
        ]);
    }

    public static function getDefaultPriority(): int
    {
        return -1;
    }
}
