<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context\Setup;

use App\Fixture\Factory\AdminUserExampleFactory;
use Behat\Behat\Context\Context;
use Monofony\Bundle\CoreBundle\Tests\Behat\Service\SharedStorageInterface;
use Sylius\Component\User\Repository\UserRepositoryInterface;

final class AdminUserContext implements Context
{
    /**
     * @var SharedStorageInterface
     */
    private $sharedStorage;

    /**
     * @var AdminUserExampleFactory
     */
    private $userFactory;

    /**
     * @var UserRepositoryInterface
     */
    private $adminUserRepository;

    public function __construct(
        SharedStorageInterface $sharedStorage,
        AdminUserExampleFactory $userFactory,
        UserRepositoryInterface $adminUserRepository
    ) {
        $this->sharedStorage = $sharedStorage;
        $this->userFactory = $userFactory;
        $this->adminUserRepository = $adminUserRepository;
    }

    /**
     * @Given there is an administrator :email identified by :password
     * @Given /^there is(?:| also) an administrator "([^"]+)"$/
     */
    public function thereIsAnAdministratorIdentifiedBy($email, $password = 'admin'): void
    {
        $adminUser = $this->userFactory->create(['email' => $email, 'password' => $password, 'enabled' => true]);
        $this->adminUserRepository->add($adminUser);
        $this->sharedStorage->set('administrator', $adminUser);
    }

    /**
     * @Given there is an administrator with name :username
     */
    public function thereIsAnAdministratorWithName($username): void
    {
        $adminUser = $this->userFactory->create(['username' => $username]);
        $adminUser->setUsername($username);

        $this->adminUserRepository->add($adminUser);
        $this->sharedStorage->set('administrator', $adminUser);
    }
}
