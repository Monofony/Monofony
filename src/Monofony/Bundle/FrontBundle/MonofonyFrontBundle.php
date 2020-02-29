<?php

declare(strict_types=1);

namespace Monofony\Bundle\FrontBundle;

use App\Monofony\Bundle\AdminBundle\Menu\AdminMenuBuilderInterface;
use Monofony\Bundle\AdminBundle\Dashboard\Statistics\StatisticInterface;
use Monofony\Bundle\FrontBundle\Menu\AccountMenuBuilderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class MonofonyFrontBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        $this->buildAccountMenu($container);
    }

    private function buildAccountMenu(ContainerBuilder $container): void
    {
        $container->registerForAutoconfiguration(AccountMenuBuilderInterface::class)
            ->addTag('knp_menu.menu_builder', [
                'method' => 'createMenu',
                'alias' => 'app.account',
            ]);
    }
}
