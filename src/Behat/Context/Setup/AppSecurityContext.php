<?php

/*
 * This file is part of Jedisjeux.
 *
 * (c) Loïc Frémont
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Behat\Context\Setup;

use App\Behat\Service\SecurityServiceInterface;
use App\Behat\Service\SharedStorageInterface;
use App\Entity\AppUser;
use App\Fixture\Factory\AdminUserExampleFactory;
use App\Fixture\Factory\ExampleFactoryInterface;
use Behat\Behat\Context\Context;
use Sylius\Component\User\Repository\UserRepositoryInterface;
use Webmozart\Assert\Assert;

final class AppSecurityContext implements Context
{
    /**
     * @var SharedStorageInterface
     */
    private $sharedStorage;

    /**
     * @var SecurityServiceInterface
     */
    private $securityService;

    /**
     * @var AdminUserExampleFactory
     */
    private $userFactory;

    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @param SharedStorageInterface   $sharedStorage
     * @param SecurityServiceInterface $securityService
     * @param AdminUserExampleFactory  $userFactory
     * @param UserRepositoryInterface  $userRepository
     */
    public function __construct(
        SharedStorageInterface $sharedStorage,
        SecurityServiceInterface $securityService,
        AdminUserExampleFactory $userFactory,
        UserRepositoryInterface $userRepository
    ) {
        $this->sharedStorage = $sharedStorage;
        $this->securityService = $securityService;
        $this->userFactory = $userFactory;
        $this->userRepository = $userRepository;
    }

    /**
     * @Given I am logged in as :email
     */
    public function iAmLoggedInAs($email)
    {
        $user = $this->userRepository->findOneByEmail($email);
        Assert::notNull($user);

        $this->securityService->logIn($user);
    }

    /**
     * @Given I am a logged in customer
     */
    public function iAmLoggedInAsACustomer()
    {
        /** @var AppUser $user */
        $user = $this->userFactory->create(['email' => 'customer@example.com', 'password' => 'password', 'roles' => ['ROLE_USER']]);
        $this->userRepository->add($user);

        $this->securityService->logIn($user);

        $this->sharedStorage->set('customer', $user->getCustomer());
    }
}
