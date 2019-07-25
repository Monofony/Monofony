<?php

namespace spec\App\Controller;

use App\Controller\DashboardController;
use App\Dashboard\DashboardStatistics;
use App\Dashboard\DashboardStatisticsProvider;
use PhpSpec\ObjectBehavior;
use Psr\Container\ContainerInterface;
use Symfony\Component\Templating\EngineInterface;

class DashboardControllerSpec extends ObjectBehavior
{
    function let(DashboardStatisticsProvider $statisticsProvider, ContainerInterface $container): void
    {
        $this->beConstructedWith($statisticsProvider);
        $this->setContainer($container);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(DashboardController::class);
    }

    function it_renders_statistics(
        DashboardStatisticsProvider $statisticsProvider,
        DashboardStatistics $statistics,
        ContainerInterface $container,
        EngineInterface $engine
    ): void {
        $statisticsProvider->getStatistics()->willReturn($statistics);
        $container->has('templating')->willReturn(true);
        $container->get('templating')->willReturn($engine);

        $engine->render('backend/index.html.twig', ['statistics' => $statistics])->shouldBeCalled();

        $this->indexAction();
    }
}
