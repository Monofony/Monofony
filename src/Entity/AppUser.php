<?php

/*
 * This file is part of AppName.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Customer\Model\CustomerInterface;
use Sylius\Component\Resource\Exception\UnexpectedTypeException;
use Sylius\Component\User\Model\User as BaseUser;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_app_user")
 */
class AppUser extends BaseUser
{
    /**
     * @var CustomerInterface
     *
     * @ORM\OneToOne(targetEntity="Sylius\Component\Customer\Model\CustomerInterface", inversedBy="user", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    protected $customer;

    /**
     * @return CustomerInterface
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @param CustomerInterface $customer
     *
     * @return $this
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        if (null === $this->customer) {
            return null;
        }

        return $this->customer->getEmail();
    }

    /**
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        if (null === $this->customer) {
            throw new UnexpectedTypeException($this->customer, CustomerInterface::class);
        }

        $this->customer->setEmail($email);
    }

    /**
     * @return string|null
     */
    public function getEmailCanonical(): ?string
    {
        if (null === $this->customer) {
            return null;
        }

        return $this->customer->getEmailCanonical();
    }

    /**
     * @param string|null $emailCanonical
     */
    public function setEmailCanonical(?string $emailCanonical): void
    {
        if (null === $this->customer) {
            throw new UnexpectedTypeException($this->customer, CustomerInterface::class);
        }

        $this->customer->setEmailCanonical($emailCanonical);
    }

    /**
     * @param Customer $customer
     */
    protected function assignUser(Customer $customer = null)
    {
        if (null !== $customer) {
            $customer->setUser($this);
        }
    }
}
