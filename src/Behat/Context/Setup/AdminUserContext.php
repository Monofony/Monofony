<?php

/*
 * This file is part of AppName.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Behat\Context\Setup;

use Behat\Behat\Context\Context;
use App\Behat\Service\SharedStorageInterface;
use App\Fixture\Factory\ExampleFactoryInterface;
use Sylius\Component\User\Repository\UserRepositoryInterface;

final class AdminUserContext implements Context
{
    /**
     * @var SharedStorageInterface
     */
    private $sharedStorage;

    /**
     * @var ExampleFactoryInterface
     */
    private $userFactory;

    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @param SharedStorageInterface  $sharedStorage
     * @param ExampleFactoryInterface $userFactory
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
        SharedStorageInterface $sharedStorage,
        ExampleFactoryInterface $userFactory,
        UserRepositoryInterface $userRepository
    ) {
        $this->sharedStorage = $sharedStorage;
        $this->userFactory = $userFactory;
        $this->userRepository = $userRepository;
    }

    /**
     * @Given there is an administrator :email identified by :password
     * @Given /^there is(?:| also) an administrator "([^"]+)"$/
     */
    public function thereIsAnAdministratorIdentifiedBy($email, $password = 'admin')
    {
        $adminUser = $this->userFactory->create(['email' => $email, 'password' => $password, 'enabled' => true]);
        $this->userRepository->add($adminUser);
        $this->sharedStorage->set('administrator', $adminUser);
    }

    /**
     * @Given there is an administrator with name :username
     */
    public function thereIsAnAdministratorWithName($username)
    {
        $adminUser = $this->userFactory->create(['username' => $username]);
        $adminUser->setUsername($username);

        $this->userRepository->add($adminUser);
        $this->sharedStorage->set('administrator', $adminUser);
    }
}
