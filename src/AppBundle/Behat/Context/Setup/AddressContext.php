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
     * @Given there are :count addresses located at :city
     */
    public function thereAreAddressesLocatedAtCity($count, $city)
    {
        $manager = $this->getEntityManager();
        $factory = $this->getExampleFactory('address');

        for ($i=0 ; $i<$count ; $i++) {
            $address = $factory->create(['city' => $city]);

            $manager->persist($address);
        }

        $manager->flush();
    }
}
