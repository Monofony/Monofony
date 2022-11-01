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
use Symfony\Component\HttpFoundation\RequestStack;

final class AdminSecurityService extends AbstractSecurityService implements AdminSecurityServiceInterface
{
    public function __construct(RequestStack $requestStack, CookieSetterInterface $cookieSetter)
    {
        parent::__construct($requestStack, $cookieSetter, 'admin');
    }
}
