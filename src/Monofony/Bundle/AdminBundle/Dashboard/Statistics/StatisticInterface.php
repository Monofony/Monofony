<?php

namespace Monofony\Bundle\AdminBundle\Dashboard\Statistics;

interface StatisticInterface
{
    public function generate(): string;
}
