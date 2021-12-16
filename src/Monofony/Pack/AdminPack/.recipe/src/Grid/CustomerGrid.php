<?php

declare(strict_types=1);

namespace App\Grid;

use App\Entity\Customer\Customer;
use Sylius\Bundle\GridBundle\Builder\Action\CreateAction;
use Sylius\Bundle\GridBundle\Builder\Action\ShowAction;
use Sylius\Bundle\GridBundle\Builder\Action\UpdateAction;
use Sylius\Bundle\GridBundle\Builder\ActionGroup\ItemActionGroup;
use Sylius\Bundle\GridBundle\Builder\ActionGroup\MainActionGroup;
use Sylius\Bundle\GridBundle\Builder\Field\DateTimeField;
use Sylius\Bundle\GridBundle\Builder\Field\StringField;
use Sylius\Bundle\GridBundle\Builder\Filter\StringFilter;
use Sylius\Bundle\GridBundle\Builder\GridBuilderInterface;
use Sylius\Bundle\GridBundle\Grid\AbstractGrid;
use Sylius\Bundle\GridBundle\Grid\ResourceAwareGridInterface;

final class CustomerGrid extends AbstractGrid implements ResourceAwareGridInterface
{
    public static function getName(): string
    {
        return 'sylius_backend_customer';
    }

    public function buildGrid(GridBuilderInterface $gridBuilder): void
    {
        $gridBuilder
            ->orderBy('createdAt', 'desc')
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
                StringField::create('email')
                    ->setLabel('sylius.ui.email')
                    ->setSortable(true)
            )
            ->addField(
                DateTimeField::create('createdAt')
                    ->setLabel('sylius.ui.registration_date')
                    ->setSortable(true)
            )
            ->addFilter(StringFilter::create('search', ['email', 'firstName', 'lastName']))
            ->addActionGroup(
                MainActionGroup::create(
                    CreateAction::create(),
                )
            )
            ->addActionGroup(
                ItemActionGroup::create(
                    ShowAction::create(),
                    UpdateAction::create(),
                )
            )
        ;
    }

    public function getResourceClass(): string
    {
        return Customer::class;
    }
}
