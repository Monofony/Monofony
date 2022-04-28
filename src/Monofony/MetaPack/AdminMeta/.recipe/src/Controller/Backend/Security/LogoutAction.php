<?php

declare(strict_types=1);

namespace App\Controller\Backend\Security;

use Sylius\Component\Resource\Annotation\SyliusRoute;

#[SyliusRoute(
    name: 'sylius_backend_logout',
    path: '/admin/logout',
)]
final class LogoutAction
{
}
