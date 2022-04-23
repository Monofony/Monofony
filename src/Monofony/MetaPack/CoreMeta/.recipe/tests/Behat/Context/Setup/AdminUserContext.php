<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context\Setup;

use App\Factory\AdminUserFactory;
use Behat\Behat\Context\Context;
use Monofony\Bridge\Behat\Service\SharedStorageInterface;

final class AdminUserContext implements Context
{
    public function __construct(
        private SharedStorageInterface $sharedStorage,
        private AdminUserFactory $adminUserFactory,
    ) {
    }

    /**
     * @Given there is an administrator :email identified by :password
     * @Given /^there is(?:| also) an administrator "([^"]+)"$/
     */
    public function thereIsAnAdministratorIdentifiedBy(string $email, string $password = 'admin'): void
    {
        $adminUser = $this->adminUserFactory->createOne(['email' => $email, 'password' => $password, 'enabled' => true])->object();
        $this->sharedStorage->set('administrator', $adminUser);
    }

    /**
     * @Given there is an administrator with name :username
     */
    public function thereIsAnAdministratorWithName(string $username): void
    {
        $adminUser = $this->adminUserFactory->createOne(['username' => $username])->object();

        $this->sharedStorage->set('administrator', $adminUser);
    }
}
