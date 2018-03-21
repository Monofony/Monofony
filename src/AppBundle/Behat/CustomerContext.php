<?php

/*
 * This file is part of VPS.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Behat;

use AppBundle\Entity\ContractCustomer;
use AppBundle\Entity\Customer;
use Behat\Gherkin\Node\TableNode;
use Faker\Generator;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\User\Model\UserInterface;

/**
 * @author Loïc Frémont <loic@mobizel.com>
 */
class CustomerContext extends DefaultContext
{
    /**
     * @Given /^there are customers:$/
     * @Given /^there are following customers:$/
     * @Given /^the following customers exist:$/
     *
     * @param TableNode $table
     */
    public function thereAreCustomers(TableNode $table)
    {
        $manager = $this->getEntityManager();

        foreach ($table->getHash() as $data) {

            $pilot = $this->createCustomerByData($data);
            $manager->persist($pilot);
        }

        $manager->flush();
    }

    /**
     * @param array $data
     *
     * @return Customer
     */
    protected function createCustomerByData(array $data)
    {
        /** @var Customer $customer */
        $customer = $this->getCustomerFactory()->createNew();
        self::populateCustomer($customer, $data, $this->faker);

        /** @var UserInterface $user */
        $user = $this->getFactory('app_user', 'sylius')->createNew();
        self::populateUser($user, $data, $this->faker);

        $customer->setUser($user);

        return $customer;
    }

    /**
     * @param Customer $customer
     * @param array $data
     * @param Generator $faker
     */
    public static function populateCustomer(Customer $customer, array $data, Generator $faker)
    {
        $customer->setEmail(isset($data['email']) ? trim($data['email']) : $faker->email);
        $customer->setFirstName(isset($data['first_name']) ? trim($data['first_name']) : $faker->firstName);
        $customer->setLastName(isset($data['last_name']) ? trim($data['last_name']) : $faker->lastName);
        $customer->setPhoneNumber(isset($data['phone_number']) ? trim($data['phone_number']) : $faker->phoneNumber);
    }

    /**
     * @param UserInterface $pilotUser
     * @param array $data
     * @param Generator $faker
     */
    public static function populateUser(UserInterface $pilotUser, array $data, Generator $faker)
    {
        $pilotUser->setPlainPassword(isset($data['password']) ? trim($data['password']) : $faker->password());
        $pilotUser->setEnabled(isset($data['enabled']) ? trim($data['enabled']) : true);
    }

    /**
     * @return FactoryInterface|object
     */
    protected function getCustomerFactory()
    {
        return $this->getContainer()->get('sylius.factory.customer');
    }
}