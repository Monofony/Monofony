<?php

namespace App\Tests\Behat\Context\Setup;

use Monofony\Bundle\CoreBundle\Tests\Behat\Service\AppSecurityServiceInterface;
use Monofony\Bundle\CoreBundle\Tests\Behat\Service\SharedStorageInterface;
use Monofony\Component\Core\Model\User\AppUserInterface;
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
     * @var AppSecurityServiceInterface
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

    public function __construct(
        SharedStorageInterface $sharedStorage,
        AppSecurityServiceInterface $securityService,
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
