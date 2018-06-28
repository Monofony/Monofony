<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Behat\Service;

use Sylius\Component\User\Model\UserInterface;

/**
 * @author Arkadiusz Krakowiak <arkadiusz.krakowiak@lakion.com>
 */
interface SharedSecurityServiceInterface
{
    /**
     * @param UserInterface $adminUser
     * @param callable $action
     */
    public function performActionAsAdminUser(UserInterface $adminUser, callable $action);
}
