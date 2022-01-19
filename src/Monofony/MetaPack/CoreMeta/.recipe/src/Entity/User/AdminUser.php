<?php

declare(strict_types=1);

namespace App\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use Monofony\Contracts\Core\Model\User\AdminAvatarInterface;
use Monofony\Contracts\Core\Model\User\AdminUserInterface;
use Sylius\Component\User\Model\User as BaseUser;

#[ORM\Entity]
#[ORM\Table(name: 'sylius_admin_user')]
class AdminUser extends BaseUser implements AdminUserInterface
{
    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $lastName = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $firstName = null;

    #[ORM\OneToOne(targetEntity: AdminAvatar::class, cascade: ['persist'])]
    private ?AdminAvatarInterface $avatar = null;

    public function __construct()
    {
        parent::__construct();

        $this->roles = [self::DEFAULT_ADMIN_ROLE];
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getAvatar(): ?AdminAvatarInterface
    {
        return $this->avatar;
    }

    public function setAvatar(?AdminAvatarInterface $avatar): void
    {
        $this->avatar = $avatar;
    }
}
