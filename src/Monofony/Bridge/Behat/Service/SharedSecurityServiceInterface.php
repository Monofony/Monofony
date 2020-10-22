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

use Sylius\Component\User\Model\UserInterface;

interface SharedSecurityServiceInterface
{
    public function performActionAsAdminUser(UserInterface $adminUser, callable $action);
}
