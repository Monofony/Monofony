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

namespace App\Controller;

use App\Dashboard\DashboardStatisticsProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends AbstractController
{
    /** @var DashboardStatisticsProvider */
    private $statisticsProvider;

    public function __construct(DashboardStatisticsProvider $statisticsProvider)
    {
        $this->statisticsProvider = $statisticsProvider;
    }

    public function indexAction(): Response
    {
        $statistics = $this->statisticsProvider->getStatistics();

        return $this->render('backend/index.html.twig', ['statistics' => $statistics]);
    }
}
