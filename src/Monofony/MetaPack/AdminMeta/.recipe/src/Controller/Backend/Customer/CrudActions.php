<?php


declare(strict_types=1);

namespace App\Controller\Backend\Customer;

use Sylius\Component\Resource\Annotation\SyliusCrudRoutes;

#[SyliusCrudRoutes(
    alias: 'sylius.customer',
    path: '/admin/customers',
    section: 'backend',
    redirect: 'index',
    templates: 'backend/crud',
    grid: 'sylius_backend_customer',
    except: ['show'],
    vars: [
        'all' => [
            'subheader' => 'sylius.ui.manage_your_customers',
            'templates' => ['form' => 'backend/customer/_form.html.twig'],
        ],
        'index' => ['icon' => 'users'],
    ],
)]
final class CrudActions
{
}
