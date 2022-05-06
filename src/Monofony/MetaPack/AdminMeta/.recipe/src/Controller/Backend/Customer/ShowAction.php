<?php

declare(strict_types=1);

namespace App\Controller\Backend\Customer;

use Sylius\Component\Resource\Annotation\SyliusRoute;

#[SyliusRoute(
    name: 'sylius_backend_customer_show',
    path: '/admin/customers/{id}',
    controller: 'sylius.controller.customer::showAction',
    template: 'backend/customer/show.html.twig',
    section: 'backend',
    permission: true,
)]
final class ShowAction
{
}
