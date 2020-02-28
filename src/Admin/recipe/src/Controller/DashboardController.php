<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dashboard\DashboardStatisticsProvider;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Templating\EngineInterface;

final class DashboardController
{
    /** @var DashboardStatisticsProvider */
    private $statisticsProvider;

    /** @var EngineInterface */
    private $templating;

    public function __construct(DashboardStatisticsProvider $statisticsProvider, EngineInterface $templating)
    {
        $this->statisticsProvider = $statisticsProvider;
        $this->templating = $templating;
    }

    public function indexAction(): Response
    {
        $statistics = $this->statisticsProvider->getStatistics();
        $content = $this->templating->render('backend/index.html.twig', ['statistics' => $statistics]);

        return new Response($content);
    }
}
