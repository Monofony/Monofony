<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace AppBundle\Behat\Context\Setup;

use Behat\Behat\Context\Context;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Behat\Service\SharedStorageInterface;
use AppBundle\Entity\Customer;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Sylius\Component\User\Model\User;

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
    private $userFactory;

    /**
     * @param SharedStorageInterface $sharedStorage
     * @param RepositoryInterface $customerRepository
     * @param ObjectManager $customerManager
     * @param FactoryInterface $customerFactory
     * @param FactoryInterface $userFactory
     */
    public function __construct(
        SharedStorageInterface $sharedStorage,
        RepositoryInterface $customerRepository,
        ObjectManager $customerManager,
        FactoryInterface $customerFactory,
        FactoryInterface $userFactory
    ) {
        $this->sharedStorage = $sharedStorage;
        $this->customerRepository = $customerRepository;
        $this->customerManager = $customerManager;
        $this->customerFactory = $customerFactory;
        $this->userFactory = $userFactory;
    }

    /**
     * @Given there is customer :name with email :email
     */
    public function thereIsCustomerWithNameAndEmail($name, $email)
    {
        $partsOfName = explode(' ', $name);
        $customer = $this->createCustomer($email, $partsOfName[0], $partsOfName[1]);
        $this->customerRepository->add($customer);
    }

    /**
     * @Given there is (also )customer :email
     */
    public function thereIsCustomer($email)
    {
        $customer = $this->createCustomer($email);

        $this->customerRepository->add($customer);
    }

    /**
     * @Given there is customer :email with first name :firstName
     */
    public function thereIsCustomerWithFirstName($email, $firstName)
    {
        $customer = $this->createCustomer($email, $firstName);

        $this->customerRepository->add($customer);
    }

    /**
     * @param string $email
     * @param string|null $firstName
     * @param string|null $lastName
     * @param \DateTimeInterface|null $createdAt
     * @param string|null $phoneNumber
     *
     * @return Customer
     */
    private function createCustomer(
        $email,
        $firstName = null,
        $lastName = null,
        \DateTimeInterface $createdAt = null,
        $phoneNumber = null
    ) {
        /** @var Customer $customer */
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

    /**
     * @param string $email
     * @param string $password
     * @param bool $enabled
     * @param string|null $firstName
     * @param string|null $lastName
     * @param string|null $role
     *
     * @return Customer
     */
    private function createCustomerWithUserAccount(
        $email,
        $password,
        $enabled = true,
        $firstName = null,
        $lastName = null,
        $role = null
    ) {
        /** @var User $user */
        $user = $this->userFactory->createNew();
        /** @var Customer $customer */
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
