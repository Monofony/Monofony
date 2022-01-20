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

namespace Monofony\Contracts\Core\Model\User;

use Sylius\Component\User\Model\UserInterface as BaseUserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

interface AdminUserInterface extends BaseUserInterface, PasswordAuthenticatedUserInterface
{
    public const DEFAULT_ADMIN_ROLE = 'ROLE_ADMIN';

    public function getFirstName(): ?string;

    public function setFirstName(?string $firstName): void;

    public function getLastName(): ?string;

    public function setLastName(?string $lastName): void;

    public function getAvatar(): ?AdminAvatarInterface;

    public function setAvatar(?AdminAvatarInterface $avatar): void;
}
