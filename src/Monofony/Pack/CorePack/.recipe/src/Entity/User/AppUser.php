<?php

declare(strict_types=1);

namespace App\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use Monofony\Contracts\Core\Model\User\AppUserInterface;
use Sylius\Component\Customer\Model\CustomerInterface;
use Sylius\Component\Resource\Exception\UnexpectedTypeException;
use Sylius\Component\User\Model\User as BaseUser;

#[ORM\Entity]
#[ORM\Table(name: 'sylius_app_user')]
class AppUser extends BaseUser implements AppUserInterface
{
    #[ORM\OneToOne(inversedBy: 'user', targetEntity: CustomerInterface::class, cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?CustomerInterface $customer = null;

    public function getCustomer(): ?CustomerInterface
    {
        return $this->customer;
    }

    public function setCustomer($customer): void
    {
        $this->customer = $customer;
    }

    public function getEmail(): ?string
    {
        if (null === $this->customer) {
            return null;
        }

        return $this->customer->getEmail();
    }

    public function setEmail(?string $email): void
    {
        if (null === $this->customer) {
            throw new UnexpectedTypeException($this->customer, CustomerInterface::class);
        }

        $this->customer->setEmail($email);
    }

    public function getEmailCanonical(): ?string
    {
        if (null === $this->customer) {
            return null;
        }

        return $this->customer->getEmailCanonical();
    }

    public function setEmailCanonical(?string $emailCanonical): void
    {
        if (null === $this->customer) {
            throw new UnexpectedTypeException($this->customer, CustomerInterface::class);
        }

        $this->customer->setEmailCanonical($emailCanonical);
    }
}
