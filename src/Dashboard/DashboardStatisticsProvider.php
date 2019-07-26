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

use App\Repository\CustomerRepository;
use Sylius\Component\Resource\Repository\RepositoryInterface;

class DashboardStatisticsProvider
{
    /** @var CustomerRepository */
    private $customerRepository;

    public function __construct(RepositoryInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function getStatistics(): DashboardStatistics
    {
        return new DashboardStatistics(
            $this->customerRepository->countCustomers()
        );
    }
}
