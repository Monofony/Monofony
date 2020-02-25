<?php

declare(strict_types=1);

namespace App\Entity\User;

use Sylius\Component\Customer\Model\CustomerAwareInterface;
use Sylius\Component\User\Model\UserInterface;

interface AppUserInterface extends UserInterface, CustomerAwareInterface
{
}
