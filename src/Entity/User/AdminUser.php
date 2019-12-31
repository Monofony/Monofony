<?php

/*
 * This file is part of AppName.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\User\Model\User as BaseUser;

/**
 * @ORM\Entity
 * @ORM\Table("sylius_admin_user")
 */
class AdminUser extends BaseUser implements AdminUserInterface
{
    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $lastName;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $firstName;

    /**
     * @var AdminAvatar|null
     *
     * @ORM\OneToOne(targetEntity="App\Entity\User\AdminAvatar", cascade={"persist"})
     */
    private $avatar;

    public function __construct()
    {
        parent::__construct();

        $this->roles = [self::DEFAULT_ADMIN_ROLE];
    }

    /**
     * {@inheritdoc}
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * {@inheritdoc}
     */
    public function setLastName(?string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * {@inheritdoc}
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * {@inheritdoc}
     */
    public function setFirstName(?string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * {@inheritdoc}
     */
    public function getAvatar(): ?AdminAvatar
    {
        return $this->avatar;
    }

    /**
     * {@inheritdoc}
     */
    public function setAvatar(?AdminAvatar $avatar): void
    {
        $this->avatar = $avatar;
    }
}
