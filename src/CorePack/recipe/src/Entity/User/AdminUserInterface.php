<?php



declare(strict_types=1);

namespace App\Entity\User;

use Sylius\Component\User\Model\UserInterface as BaseUserInterface;

interface AdminUserInterface extends BaseUserInterface
{
    public const DEFAULT_ADMIN_ROLE = 'ROLE_ADMIN';

    public function getFirstName(): ?string;

    function setFirstName(?string $firstName): void;

    public function getLastName(): ?string;

    public function setLastName(?string $lastName): void;

    public function getAvatar(): ?AdminAvatarInterface;

    public function setAvatar(?AdminAvatarInterface $avatar): void;
}
