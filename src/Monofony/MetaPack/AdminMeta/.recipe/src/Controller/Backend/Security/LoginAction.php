<?php

declare(strict_types=1);

namespace App\Controller\Backend\Security;

use Sylius\Component\Resource\Annotation\SyliusRoute;

#[SyliusRoute(
    name: 'sylius_backend_login',
    path: '/admin/login',
    controller: 'sylius.controller.security::loginAction',
    template: 'backend/security/login.html.twig',
    permission: true,
)]
final class LoginAction
{
}
