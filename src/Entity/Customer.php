<?php

/*
 * This file is part of Monofony.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Customer\Model\Customer as BaseCustomer;
use Sylius\Component\User\Model\UserAwareInterface;
use Sylius\Component\User\Model\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_customer")
 */
class Customer extends BaseCustomer implements UserAwareInterface
{
    /**
     * @var AppUser
     *
     * @ORM\OneToOne(targetEntity="App\Entity\AppUser", mappedBy="customer", cascade={"persist"})
     *
     * @Assert\Valid
     */
    private $user;

    /**
     * @return AppUser
     */
    public function getUser(): ?UserInterface
    {
        return $this->user;
    }

    /**
     * @param UserInterface|null $user
     *
     * @return $this
     */
    public function setUser(?UserInterface $user)
    {
        if ($this->user !== $user) {
            $this->user = $user;
            $this->assignCustomer($user);
        }

        return $this;
    }

    /**
     * @param AppUser|null $user
     */
    protected function assignCustomer($user = null)
    {
        if (null !== $user) {
            $user->setCustomer($this);
        }
    }
}
