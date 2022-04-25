<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context\Setup;

use App\Factory\AdminUserFactory;
use Behat\Behat\Context\Context;
use Monofony\Bridge\Behat\Service\AdminSecurityServiceInterface;
use Monofony\Bridge\Behat\Service\SharedStorageInterface;
use Sylius\Component\User\Model\UserInterface;
use Sylius\Component\User\Repository\UserRepositoryInterface;
use Webmozart\Assert\Assert;

final class AdminSecurityContext implements Context
{
    public function __construct(
        private SharedStorageInterface $sharedStorage,
        private AdminSecurityServiceInterface $securityService,
        private AdminUserFactory $userFactory,
        private UserRepositoryInterface $adminUserRepository,
    ) {
    }

    /**
     * @Given I am logged in as an administrator
     */
    public function iAmLoggedInAsAnAdministrator(): void
    {
        $user = $this->userFactory
            ->createOne(['email' => 'admin@example.com', 'password' => 'admin'])
        ;

        /** @var UserInterface $user */
        $user = $this->adminUserRepository->find($user->getId());

        $this->securityService->logIn($user);

        $this->sharedStorage->set('administrator', $user);
    }

    /**
     * @Given /^I am logged in as "([^"]+)" administrator$/
     */
    public function iAmLoggedInAsAdministrator(string $email): void
    {
        $user = $this->adminUserRepository->findOneByEmail($email);
        Assert::notNull($user);

        $this->securityService->logIn($user);

        $this->sharedStorage->set('administrator', $user);
    }
}
