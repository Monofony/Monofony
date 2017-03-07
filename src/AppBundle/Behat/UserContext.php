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

use AppBundle\Entity\User;
use Behat\Gherkin\Node\TableNode;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Customer\Model\CustomerInterface;
use Sylius\Component\User\Canonicalizer\Canonicalizer;
use Sylius\Component\User\Model\UserInterface;

/**
 * @author Loïc Frémont <loic@mobizel.com>
 */
class UserContext extends DefaultContext
{
    /**
     * @Given /^I am logged in as user "([^""]*)" with password "([^""]*)"$/
     */
    public function iAmLoggedInUserWithPassword($username, $password)
    {
        $this->visitPath("/login");
        $this->fillField("E-mail", $username);
        $this->fillField('Mot de passe', $password);
        $this->pressButton('Connexion');
    }
}
