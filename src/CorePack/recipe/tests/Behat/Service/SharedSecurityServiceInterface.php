<?php

/*
 * This file is part of AppName.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tests\Behat\Service;

use Sylius\Component\User\Model\UserInterface;

interface SharedSecurityServiceInterface
{
    /**
     * @param UserInterface $adminUser
     * @param callable      $action
     */
    public function performActionAsAdminUser(UserInterface $adminUser, callable $action);
}
