<?php

/*
 * This file is part of Jedisjeux.
 *
 * (c) Loïc Frémont
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tests\Behat\Context\Setup;

use App\Tests\Behat\Service\SecurityServiceInterface;
use App\Tests\Behat\Service\SharedStorageInterface;
use App\Entity\User\AppUserInterface;
use App\Fixture\Factory\AdminUserExampleFactory;
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
    private $appUserRepository;

    /**
     * @param SharedStorageInterface   $sharedStorage
     * @param SecurityServiceInterface $securityService
     * @param AdminUserExampleFactory  $userFactory
     * @param UserRepositoryInterface  $appUserRepository
     */
    public function __construct(
        SharedStorageInterface $sharedStorage,
        SecurityServiceInterface $securityService,
        AdminUserExampleFactory $userFactory,
        UserRepositoryInterface $appUserRepository
    ) {
        $this->sharedStorage = $sharedStorage;
        $this->securityService = $securityService;
        $this->userFactory = $userFactory;
        $this->appUserRepository = $appUserRepository;
    }

    /**
     * @Given I am logged in as :email
     */
    public function iAmLoggedInAs($email): void
    {
        $user = $this->appUserRepository->findOneByEmail($email);
        Assert::notNull($user);

        $this->securityService->logIn($user);
    }

    /**
     * @Given I am a logged in customer
     */
    public function iAmLoggedInAsACustomer(): void
    {
        /** @var AppUserInterface $user */
        $user = $this->userFactory->create(['email' => 'customer@example.com', 'password' => 'password', 'roles' => ['ROLE_USER']]);
        $this->appUserRepository->add($user);

        $this->securityService->logIn($user);

        $this->sharedStorage->set('customer', $user->getCustomer());
    }
}
