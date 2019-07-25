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

class DashboardStatistics
{
    /** @var int */
    private $numberOfNewCustomers;

    public function __construct(int $numberOfNewCustomers)
    {
        $this->numberOfNewCustomers = $numberOfNewCustomers;
    }

    public function getNumberOfNewCustomers(): int
    {
        return $this->numberOfNewCustomers;
    }
}
