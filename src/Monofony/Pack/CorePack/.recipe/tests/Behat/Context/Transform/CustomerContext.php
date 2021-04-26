<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context\Transform;

use Behat\Behat\Context\Context;
use Monofony\Bridge\Behat\Service\SharedStorageInterface;
use Sylius\Component\Customer\Model\CustomerInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

final class CustomerContext implements Context
{
    private RepositoryInterface $customerRepository;
    private FactoryInterface $customerFactory;
    private SharedStorageInterface $sharedStorage;

    public function __construct(
        RepositoryInterface $customerRepository,
        FactoryInterface $customerFactory,
        SharedStorageInterface $sharedStorage
    ) {
        $this->customerRepository = $customerRepository;
        $this->customerFactory = $customerFactory;
        $this->sharedStorage = $sharedStorage;
    }

    /**
     * @Transform :customer
     * @Transform /^customer "([^"]+)"$/
     */
    public function getOrCreateCustomerByEmail($email): object
    {
        /** @var CustomerInterface $customer */
        $customer = $this->customerRepository->findOneBy(['email' => $email]);
        if (null === $customer) {
            $customer = $this->customerFactory->createNew();
            $customer->setEmail($email);

            $this->customerRepository->add($customer);
        }

        return $customer;
    }

    /**
     * @Transform /^(he|his|she|her|their|the customer of my account)$/
     */
    public function getLastCustomer()
    {
        return $this->sharedStorage->get('customer');
    }
}
