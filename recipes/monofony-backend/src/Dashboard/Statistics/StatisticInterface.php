<?php

namespace App\Dashboard\Statistics;

interface StatisticInterface
{
    public function generate() : string;
}
