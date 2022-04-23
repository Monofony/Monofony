<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context\Setup;

use App\Factory\AppUserFactory;
use Behat\Behat\Context\Context;
use Monofony\Bridge\Behat\Service\AppSecurityServiceInterface;
use Monofony\Bridge\Behat\Service\SharedStorageInterface;
use Monofony\Contracts\Core\Model\User\AppUserInterface;
use Sylius\Component\User\Repository\UserRepositoryInterface;
use Webmozart\Assert\Assert;

final class AppSecurityContext implements Context
{
    public function __construct(
        private SharedStorageInterface $sharedStorage,
        private AppSecurityServiceInterface $securityService,
        private AppUserFactory $userFactory,
        private UserRepositoryInterface $appUserRepository,
    ) {
    }

    /**
     * @Given I am logged in as :email
     */
    public function iAmLoggedInAs(string $email): void
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
        $user = $this->userFactory->createOne(['email' => 'customer@example.com', 'password' => 'password', 'roles' => ['ROLE_USER']])->object();

        $this->securityService->logIn($user);

        $this->sharedStorage->set('customer', $user->getCustomer());
    }
}
