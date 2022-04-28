<?php


declare(strict_types=1);

namespace App\Controller\Backend\AdminUser;

use Sylius\Component\Resource\Annotation\SyliusCrudRoutes;

#[SyliusCrudRoutes(
    alias: 'sylius.admin_user',
    path: '/admin/users',
    section: 'backend',
    redirect: 'index',
    templates: 'backend/crud',
    grid: 'sylius_backend_admin_user',
    except: ['show'],
    vars: [
        'all' => [
            'subheader' => 'sylius.ui.manage_users_able_to_access_administration_panel',
            'templates' => ['form' => 'backend/admin_user/_form.html.twig'],
        ],
        'index' => ['icon' => 'lock'],
    ],
)]
final class CrudActions
{
}
