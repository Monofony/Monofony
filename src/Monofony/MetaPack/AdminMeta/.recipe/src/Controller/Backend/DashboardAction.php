<?php

declare(strict_types=1);

namespace App\Controller\Backend;

use Monofony\Contracts\Admin\Dashboard\DashboardStatisticsProviderInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

final class DashboardAction
{
    public function __construct(
        private DashboardStatisticsProviderInterface $statisticsProvider,
        private Environment $twig,
    ) {
    }

    #[Route(path: '/admin', name: 'app_backend_dashboard')]
    public function __invoke(): Response
    {
        $statistics = $this->statisticsProvider->getStatistics();
        $content = $this->twig->render('backend/index.html.twig', ['statistics' => $statistics]);

        return new Response($content);
    }
}
