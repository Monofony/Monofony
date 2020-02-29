<?php

declare(strict_types=1);

namespace Monofony\Bundle\AdminBundle\Dashboard;

interface DashboardStatisticsProviderInterface
{
    public function getStatistics(): array;
}
