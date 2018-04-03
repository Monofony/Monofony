<?php

/*
 * This file is part of Jedisjeux.
 *
 * (c) Loïc Frémont
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Behat\Context\Setup;

use AppBundle\Fixture\Factory\ExampleFactoryInterface;
use Behat\Behat\Context\Context;
use Doctrine\Common\Persistence\ObjectManager;

class AddressContext implements Context
{
    /**
     * @var ObjectManager
     */
    private $entityManager;

    /**
     * @var ExampleFactoryInterface
     */
    private $factory;

    /**
     * @param ObjectManager $manager
     * @param ExampleFactoryInterface $factory
     */
    public function __construct(ObjectManager $manager, ExampleFactoryInterface $factory)
    {
        $this->entityManager = $manager;
        $this->factory = $factory;
    }

    /**
     * @Given there is an address located at :city
     */
    public function thereIsAddressLocatedAtCity(string $city)
    {
        $this->createAddresses(1, ['city' => $city]);
    }

    /**
     * @Given there are :count addresses located at :city
     */
    public function thereAreAddressesLocatedAtCity(int $count, string $city)
    {
        $this->createAddresses((int) $count, ['city' => $city]);
    }

    /**
     * @param int $count
     *
     * @param array $options
     */
    private function createAddresses(int $count, array $options = []): void
    {
        for ($i=0 ; $i<$count ; $i++) {
            $address = $this->factory->create($options);
            $this->entityManager->persist($address);
        }

        $this->entityManager->flush();
    }
}
