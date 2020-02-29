<?php

declare(strict_types=1);

namespace App\Controller;

use Monofony\Bundle\AdminBundle\Dashboard\DashboardStatisticsProviderInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Templating\EngineInterface;

final class DashboardController
{
    /** @var DashboardStatisticsProviderInterface */
    private $statisticsProvider;

    /** @var EngineInterface */
    private $templating;

    public function __construct(DashboardStatisticsProviderInterface $statisticsProvider, EngineInterface $templating)
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
