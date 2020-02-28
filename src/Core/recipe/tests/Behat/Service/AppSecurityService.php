<?php

declare(strict_types=1);

namespace App\Tests\Behat\Service;

use App\Tests\Behat\Service\Setter\CookieSetterInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

final class AppSecurityService extends AbstractSecurityService implements AppSecurityServiceInterface
{
    public function __construct(SessionInterface $session, CookieSetterInterface $cookieSetter)
    {
        parent::__construct($session, $cookieSetter, 'app');
    }
}
