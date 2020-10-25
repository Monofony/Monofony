<?php

/*
 * This file is part of the Monofony package.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Monofony\Bundle\CoreBundle\DependencyInjection;

use App\Entity\Customer\Customer;
use Doctrine\Common\EventSubscriber;
use Monofony\Component\Admin\Dashboard\DashboardStatisticsProvider;
use Monofony\Component\Admin\Dashboard\Statistics\StatisticInterface;
use Monofony\Component\Admin\Menu\AdminMenuBuilderInterface;
use Monofony\Contracts\Admin\Dashboard\DashboardStatisticsProviderInterface;
use Monofony\Contracts\Front\Menu\AccountMenuBuilderInterface;
use Sylius\Component\Customer\Context\CustomerContextInterface;
use Sylius\Component\User\Canonicalizer\CanonicalizerInterface;
use Sylius\Component\User\Security\Generator\GeneratorInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class MonofonyCoreExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config')
        );
        $loader->load('services.yaml');

        $this->registerSomeSyliusAliases($container);
        $this->tagCustomerContext($container);
        $this->tagDoctrineEventSubscribers($container);
        $this->buildAccountMenu($container);
        $this->buildDashboardServices($container);
        $this->buildAdminMenu($container);
        $this->registerDashboardStatisticsProvider($container);
    }

    private function registerSomeSyliusAliases(ContainerBuilder $container): void
    {
        if (interface_exists(CanonicalizerInterface::class)) {
            $container->setAlias(CanonicalizerInterface::class, 'sylius.canonicalizer');
        }

        if (interface_exists(GeneratorInterface::class)) {
            $container->setAlias(GeneratorInterface::class, 'sylius.app_user.token_generator.email_verification');
        }
    }

    private function tagCustomerContext(ContainerBuilder $container): void
    {
        if (!interface_exists(CustomerContextInterface::class)) {
            return;
        }

        $container->registerForAutoconfiguration(CustomerContextInterface::class)
            ->addTag('monofony.customer_context');
    }

    private function tagDoctrineEventSubscribers(ContainerBuilder $container): void
    {
        if (!interface_exists(EventSubscriber::class)) {
            return;
        }

        $container->registerForAutoconfiguration(EventSubscriber::class)
            ->addTag('doctrine.event_subscriber');
    }

    private function buildAccountMenu(ContainerBuilder $container): void
    {
        if (!interface_exists(AccountMenuBuilderInterface::class)) {
            return;
        }

        $container->registerForAutoconfiguration(AccountMenuBuilderInterface::class)
            ->addTag('knp_menu.menu_builder', [
                'method' => 'createMenu',
                'alias' => 'app.account',
            ]);
    }

    private function buildDashboardServices(ContainerBuilder $container): void
    {
        if (!interface_exists(StatisticInterface::class)) {
            return;
        }

        $container->registerForAutoconfiguration(StatisticInterface::class)
            ->addTag('monofony.dashboard_statistic');
    }

    private function buildAdminMenu(ContainerBuilder $container): void
    {
        if (!interface_exists(AdminMenuBuilderInterface::class)) {
            return;
        }

        $container->registerForAutoconfiguration(AdminMenuBuilderInterface::class)
            ->addTag('knp_menu.menu_builder', [
                'method' => 'createMenu',
                'alias' => 'app.admin.main',
            ]);
    }

    private function registerDashboardStatisticsProvider(ContainerBuilder $container): void
    {
        if (
            !class_exists(DashboardStatisticsProvider::class)
            || !interface_exists(DashboardStatisticsProviderInterface::class)
        ) {
            return;
        }

        $container->register('monofony.admin.dashboard_statistics_provider', DashboardStatisticsProvider::class);
        $container->setAlias(DashboardStatisticsProviderInterface::class, 'monofony.admin.dashboard_statistics_provider');
    }
}
