<?php

/*
 * This file is part of AppName.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Entity;

use Sylius\Component\Customer\Model\CustomerAwareInterface;
use Sylius\Component\User\Model\UserInterface;

interface AppUserInterface extends UserInterface, CustomerAwareInterface
{
}
