<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context\Setup;

use App\Fixture\Factory\AdminUserExampleFactory;
use Behat\Behat\Context\Context;
use Monofony\Bridge\Behat\Service\AdminSecurityServiceInterface;
use Monofony\Bridge\Behat\Service\SharedStorageInterface;
use Sylius\Component\User\Model\UserInterface;
use Sylius\Component\User\Repository\UserRepositoryInterface;
use Webmozart\Assert\Assert;

final class AdminSecurityContext implements Context
{
    private SharedStorageInterface $sharedStorage;
    private AdminSecurityServiceInterface $securityService;
    private AdminUserExampleFactory $userFactory;
    private UserRepositoryInterface $adminUserRepository;

    public function __construct(
        SharedStorageInterface $sharedStorage,
        AdminSecurityServiceInterface $securityService,
        AdminUserExampleFactory $userFactory,
        UserRepositoryInterface $adminUserRepository
    ) {
        $this->sharedStorage = $sharedStorage;
        $this->securityService = $securityService;
        $this->userFactory = $userFactory;
        $this->adminUserRepository = $adminUserRepository;
    }

    /**
     * @Given I am logged in as an administrator
     */
    public function iAmLoggedInAsAnAdministrator(): void
    {
        /** @var UserInterface $user */
        $user = $this->userFactory->create(['email' => 'admin@example.com', 'password' => 'admin']);
        $this->adminUserRepository->add($user);

        $this->securityService->logIn($user);

        $this->sharedStorage->set('administrator', $user);
    }

    /**
     * @Given /^I am logged in as "([^"]+)" administrator$/
     */
    public function iAmLoggedInAsAdministrator($email): void
    {
        $user = $this->adminUserRepository->findOneByEmail($email);
        Assert::notNull($user);

        $this->securityService->logIn($user);

        $this->sharedStorage->set('administrator', $user);
    }
}
