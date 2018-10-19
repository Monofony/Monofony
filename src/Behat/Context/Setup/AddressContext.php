<?php

/*
 * This file is part of AppName.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Behat\Context\Setup;

use App\Behat\Service\SharedStorageInterface;
use App\Entity\Address;
use App\Fixture\Factory\ExampleFactoryInterface;
use Behat\Behat\Context\Context;
use Sylius\Component\Resource\Repository\RepositoryInterface;

class AddressContext implements Context
{
    /**
     * @var SharedStorageInterface
     */
    private $sharedStorage;

    /**
     * @var RepositoryInterface
     */
    private $repository;

    /**
     * @var ExampleFactoryInterface
     */
    private $factory;

    /**
     * @param SharedStorageInterface  $sharedStorage
     * @param ExampleFactoryInterface $factory
     * @param RepositoryInterface     $repository
     */
    public function __construct(
        SharedStorageInterface $sharedStorage,
        ExampleFactoryInterface $factory,
        RepositoryInterface $repository
    ) {
        $this->sharedStorage = $sharedStorage;
        $this->factory = $factory;
        $this->repository = $repository;
    }

    /**
     * @Given there is an address located at :city
     */
    public function thereIsAddressLocatedAtCity(string $city)
    {
        $this->createAddresses(1, ['city' => $city]);
    }

    /**
     * @Given there is an address with street :street located at :city
     */
    public function thereIsAddressWithStreetLocatedAtCity(string $street, string $city)
    {
        $this->createAddresses(1, [
            'street' => $street,
            'city' => $city,
        ]);
    }

    /**
     * @Given there are :count addresses located at :city
     */
    public function thereAreAddressesLocatedAtCity(int $count, string $city)
    {
        $this->createAddresses((int) $count, ['city' => $city]);
    }

    /**
     * @param int   $count
     * @param array $options
     */
    private function createAddresses(int $count, array $options = []): void
    {
        for ($i = 0; $i < $count; ++$i) {
            /** @var Address $address */
            $address = $this->factory->create($options);
            $this->repository->add($address);

            $this->sharedStorage->set('address', $address);
        }
    }
}
