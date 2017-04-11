<?php

/*
 * This file is part of AppName.
 *
 * (c) Mobizel
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Behat;

use AppBundle\Entity\Address;
use Behat\Gherkin\Node\TableNode;

/**
 * @author Loïc Frémont <loic@mobizel.com>
 */
class AddressContext extends DefaultContext
{
    /**
     * @Given there are addresses:
     * @Given there are following addresses:
     * @Given the following addresses exist:
     *
     * @param TableNode $table
     */
    public function thereAreAddresses(TableNode $table)
    {
        $manager = $this->getEntityManager();

        foreach ($table->getHash() as $data) {
            /** @var Address $address */
            $address = $this->getFactory('address')->createNew();

            $address
                ->setStreet(isset($data['street']) ? $data['street'] : $this->faker->streetAddress)
                ->setPostcode(isset($data['postcode']) ? $data['postcode'] : $this->faker->postcode)
                ->setCity(isset($data['city']) ? $data['city'] : $this->faker->city);

            $manager->persist($address);
        }

        $manager->flush();
    }
}
