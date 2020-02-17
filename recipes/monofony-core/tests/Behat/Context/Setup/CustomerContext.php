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

namespace App\Tests\Behat\Context\Setup;

use App\Entity\Customer\CustomerInterface;
use App\Entity\User\AppUserInterface;
use Behat\Behat\Context\Context;
use Doctrine\Common\Persistence\ObjectManager;
use App\Tests\Behat\Service\SharedStorageInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

final class CustomerContext implements Context
{
    /**
     * @var SharedStorageInterface
     */
    private $sharedStorage;

    /**
     * @var RepositoryInterface
     */
    private $customerRepository;

    /**
     * @var ObjectManager
     */
    private $customerManager;

    /**
     * @var FactoryInterface
     */
    private $customerFactory;

    /**
     * @var FactoryInterface
     */
    private $appUserFactory;

    /**
     * @param SharedStorageInterface $sharedStorage
     * @param RepositoryInterface    $customerRepository
     * @param ObjectManager          $customerManager
     * @param FactoryInterface       $customerFactory
     * @param FactoryInterface       $appUserFactory
     */
    public function __construct(
        SharedStorageInterface $sharedStorage,
        RepositoryInterface $customerRepository,
        ObjectManager $customerManager,
        FactoryInterface $customerFactory,
        FactoryInterface $appUserFactory
    ) {
        $this->sharedStorage = $sharedStorage;
        $this->customerRepository = $customerRepository;
        $this->customerManager = $customerManager;
        $this->customerFactory = $customerFactory;
        $this->appUserFactory = $appUserFactory;
    }

    /**
     * @Given there is a customer :name with email :email
     */
    public function thereIsCustomerWithNameAndEmail($name, $email): void
    {
        $partsOfName = explode(' ', $name);
        $customer = $this->createCustomer($email, $partsOfName[0], $partsOfName[1]);
        $this->customerRepository->add($customer);
    }

    /**
     * @Given there is (also )a customer :email
     */
    public function thereIsCustomer($email): void
    {
        $customer = $this->createCustomer($email);

        $this->customerRepository->add($customer);
    }

    /**
     * @Given there are :numberOfCustomers customers
     */
    public function thereAreCustomers(int $numberOfCustomers): void
    {
        for ($i = 0; $i < $numberOfCustomers; ++$i) {
            $customer = $this->createCustomer(sprintf('john%s@doe.com', uniqid()));
            $customer->setFirstname('John');
            $customer->setLastname('Doe'.$i);

            $this->customerRepository->add($customer);
        }
    }

    /**
     * @Given there is customer :email with first name :firstName
     */
    public function thereIsCustomerWithFirstName($email, $firstName): void
    {
        $customer = $this->createCustomer($email, $firstName);

        $this->customerRepository->add($customer);
    }

    private function createCustomer(
        string $email,
        string $firstName = null,
        string $lastName = null,
        \DateTimeInterface $createdAt = null,
        string $phoneNumber = null
    ): CustomerInterface {
        /** @var CustomerInterface $customer */
        $customer = $this->customerFactory->createNew();

        $customer->setFirstName($firstName);
        $customer->setLastName($lastName);
        $customer->setEmail($email);
        $customer->setPhoneNumber($phoneNumber);
        if (null !== $createdAt) {
            $customer->setCreatedAt($createdAt);
        }

        $this->sharedStorage->set('customer', $customer);

        return $customer;
    }

    private function createCustomerWithUserAccount(
        string $email,
        string $password,
        bool $enabled = true,
        string $firstName = null,
        string $lastName = null,
        string $role = null
    ): CustomerInterface {
        /** @var AppUserInterface $user */
        $user = $this->appUserFactory->createNew();
        /** @var CustomerInterface $customer */
        $customer = $this->customerFactory->createNew();

        $customer->setFirstName($firstName);
        $customer->setLastName($lastName);
        $customer->setEmail($email);

        $user->setUsername($email);
        $user->setPlainPassword($password);
        $user->setEnabled($enabled);
        if (null !== $role) {
            $user->addRole($role);
        }

        $customer->setUser($user);

        $this->sharedStorage->set('customer', $customer);

        return $customer;
    }
}
