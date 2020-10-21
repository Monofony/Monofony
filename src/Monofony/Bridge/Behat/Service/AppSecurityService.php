<?php

/*
 * This file is part of the Monofony package.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Monofony\Bridge\Behat\Service;

use Monofony\Bridge\Behat\Service\Setter\CookieSetterInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

final class AppSecurityService extends AbstractSecurityService implements AppSecurityServiceInterface
{
    public function __construct(SessionInterface $session, CookieSetterInterface $cookieSetter)
    {
        parent::__construct($session, $cookieSetter, 'app');
    }
}
