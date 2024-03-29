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

namespace Monofony\Contracts\Core\Model\Customer;

use Monofony\Contracts\Core\Model\User\AppUserInterface;
use Sylius\Component\Customer\Model\CustomerInterface as BaseCustomerInterface;
use Sylius\Component\User\Model\UserAwareInterface;
use Sylius\Component\User\Model\UserInterface;

interface CustomerInterface extends BaseCustomerInterface, UserAwareInterface
{
    /**
     * @return AppUserInterface|Userinterface|null
     */
    public function getUser(): ?UserInterface;

    /**
     * @param AppUserInterface|UserInterface|null $user
     */
    public function setUser(?UserInterface $user): void;
}
