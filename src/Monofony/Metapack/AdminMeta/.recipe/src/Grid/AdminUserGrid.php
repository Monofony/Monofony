<?php

declare(strict_types=1);

namespace App\Grid;

use App\Entity\User\AdminUser;
use Sylius\Bundle\GridBundle\Builder\Action\CreateAction;
use Sylius\Bundle\GridBundle\Builder\Action\DeleteAction;
use Sylius\Bundle\GridBundle\Builder\Action\UpdateAction;
use Sylius\Bundle\GridBundle\Builder\ActionGroup\BulkActionGroup;
use Sylius\Bundle\GridBundle\Builder\ActionGroup\ItemActionGroup;
use Sylius\Bundle\GridBundle\Builder\ActionGroup\MainActionGroup;
use Sylius\Bundle\GridBundle\Builder\Field\StringField;
use Sylius\Bundle\GridBundle\Builder\Field\TwigField;
use Sylius\Bundle\GridBundle\Builder\Filter\StringFilter;
use Sylius\Bundle\GridBundle\Builder\GridBuilderInterface;
use Sylius\Bundle\GridBundle\Grid\AbstractGrid;
use Sylius\Bundle\GridBundle\Grid\ResourceAwareGridInterface;

final class AdminUserGrid extends AbstractGrid implements ResourceAwareGridInterface
{
    public static function getName(): string
    {
        return 'sylius_backend_admin_user';
    }

    public function buildGrid(GridBuilderInterface $gridBuilder): void
    {
        $gridBuilder
            ->orderBy('email', 'desc')
            ->addField(
                StringField::create('firstName')
                    ->setLabel('sylius.ui.first_name')
                    ->setSortable(true)
            )
            ->addField(
                StringField::create('lastName')
                    ->setLabel('sylius.ui.last_name')
                    ->setSortable(true)
            )
            ->addField(
                StringField::create('username')
                    ->setLabel('sylius.ui.username')
                    ->setSortable(true)
            )
            ->addField(
                StringField::create('email')
                    ->setLabel('sylius.ui.email')
                    ->setSortable(true)
            )
            ->addField(
                TwigField::create('enabled', '@SyliusUi/Grid/Field/enabled.html.twig')
                    ->setLabel('sylius.ui.enabled')
                    ->setSortable(true)
            )
            ->addFilter(StringFilter::create('search', ['email', 'username', 'firstName', 'lastName']))
            ->addActionGroup(
                MainActionGroup::create(
                    CreateAction::create(),
                )
            )
            ->addActionGroup(
                ItemActionGroup::create(
                    UpdateAction::create(),
                    DeleteAction::create(),
                )
            )
            ->addActionGroup(
                BulkActionGroup::create(
                    DeleteAction::create()
                )
            )
        ;
    }

    public function getResourceClass(): string
    {
        return AdminUser::class;
    }
}
