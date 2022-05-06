<?php

declare(strict_types=1);

namespace App\Controller\Backend\Security;

use Sylius\Component\Resource\Annotation\SyliusRoute;

#[SyliusRoute(
    name: 'sylius_backend_login_check',
    path: '/admin/login-check',
    controller: 'sylius.controller.security::checkAction',
)]
final class LoginCheckAction
{
}
