<?php



declare(strict_types=1);

namespace App\DependencyInjection\Builder;

use App\Dashboard\Statistics\StatisticInterface;
use App\DependencyInjection\Compiler\ChangeCustomerContextVisibilityPass;
use App\DependencyInjection\Compiler\ConfigureDashboardStatisticsProviderPass;
use App\DependencyInjection\Compiler\RegisterPasswordListenerForResourcesPass;
use App\Menu\AdminMenuBuilder;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class CoreContainerBuilder
{
    public static function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new RegisterPasswordListenerForResourcesPass());
        $container->addCompilerPass(new ChangeCustomerContextVisibilityPass());
    }
}
