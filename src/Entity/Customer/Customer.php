<?php

/*
 * This file is part of AppName.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity\Customer;

use App\Entity\User\AppUserInterface;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Customer\Model\Customer as BaseCustomer;
use Sylius\Component\User\Model\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_customer")
 */
class Customer extends BaseCustomer implements CustomerInterface
{
    /**
     * @var AppUserInterface|UserInterface
     *
     * @ORM\OneToOne(targetEntity="App\Entity\AppUser", mappedBy="customer", cascade={"persist"})
     *
     * @Assert\Valid
     */
    private $user;

    /**
     * @return AppUserInterface|UserInterface
     */
    public function getUser(): ?UserInterface
    {
        return $this->user;
    }

    /**
     * @param AppUserInterface|UserInterface|null $user
     */
    public function setUser(?UserInterface $user): void
    {
        if ($this->user === $user) {
            return;
        }

        \Webmozart\Assert\Assert::nullOrIsInstanceOf($user, AppUserInterface::class);

        $previousUser = $this->user;
        $this->user = $user;

        if ($previousUser instanceof AppUserInterface) {
            $previousUser->setCustomer(null);
        }

        if ($user instanceof AppUserInterface) {
            $user->setCustomer($this);
        }
    }
}
