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

use AppBundle\Behat\DefaultContext;

class AddressContext extends DefaultContext
{
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
        $manager = $this->getEntityManager();
        $factory = $this->getExampleFactory('address');

        for ($i=0 ; $i<$count ; $i++) {
            $address = $factory->create($options);
            $manager->persist($address);
        }

        $manager->flush();
    }
}
