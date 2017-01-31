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

use AppBundle\Entity\AdminUser;
use Behat\Gherkin\Node\TableNode;

/**
 * @author Loïc Frémont <loic@mobizel.com>
 */
class AdminUserContext extends DefaultContext
{
    /**
     * @Given /^I am logged in on administration as user "([^""]*)" with password "([^""]*)"$/
     */
    public function iAmLoggedInUserWithPassword($username, $password)
    {
        $this->visitPath("/admin/login");
        $this->fillField("Identifiant", $username);
        $this->fillField('Mot de passe', $password);
        $this->pressButton('Login');
    }

    /**
     * @Given /^there are admin users:$/
     * @Given /^there are following admin users:$/
     * @Given /^the following admin users exist:$/
     *
     * @param TableNode $table
     */
    public function thereAreAdminUsers(TableNode $table)
    {
        $manager = $this->getEntityManager();

        foreach ($table->getHash() as $data) {
            /** @var AdminUser $adminUser */
            $adminUser = $this->getFactory('admin_user', 'sylius')->createNew();

            $adminUser->setEmail(isset($data['email']) ? $data['email'] : $this->faker->unique()->email);
            $adminUser->setPlainPassword(isset($data['password']) ? $data['password'] : $this->faker->password());
            $adminUser->setEnabled(isset($data['enabled']) ? $data['enabled'] : true);

            $manager->persist($adminUser);
        }

        $manager->flush();
    }
}
