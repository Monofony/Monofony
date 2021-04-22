<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context\Setup;

use App\Fixture\Factory\AppUserExampleFactory;
use Behat\Behat\Context\Context;
use Doctrine\Persistence\ObjectManager;
use Monofony\Bridge\Behat\Service\SharedStorageInterface;
use Monofony\Contracts\Core\Model\User\AppUserInterface;
use Sylius\Component\User\Model\UserInterface;
use Sylius\Component\User\Repository\UserRepositoryInterface;

class UserContext implements Context
{
    private SharedStorageInterface $sharedStorage;
    private UserRepositoryInterface $appUserRepository;
    private AppUserExampleFactory $userFactory;
    private ObjectManager $userManager;

    public function __construct(
        SharedStorageInterface $sharedStorage,
        UserRepositoryInterface $appUserRepository,
        AppUserExampleFactory $userFactory,
        ObjectManager $appUserManager
    ) {
        $this->sharedStorage = $sharedStorage;
        $this->appUserRepository = $appUserRepository;
        $this->userFactory = $userFactory;
        $this->userManager = $appUserManager;
    }

    /**
     * @Given there is a user :email identified by :password
     * @Given there was account of :email with password :password
     * @Given there is a user :email
     */
    public function thereIsUserIdentifiedBy($email, $password = 'sylius'): void
    {
        $user = $this->userFactory->create(['email' => $email, 'password' => $password, 'enabled' => true]);

        $this->sharedStorage->set('user', $user);

        $this->appUserRepository->add($user);
    }

    /**
     * @Given the account of :email was deleted
     * @Given my account :email was deleted
     */
    public function accountWasDeleted($email): void
    {
        /** @var AppUserInterface $user */
        $user = $this->appUserRepository->findOneByEmail($email);

        $this->sharedStorage->set('customer', $user->getCustomer());

        $this->appUserRepository->remove($user);
    }

    /**
     * @Given /^(?:(I) have|(this user) has) already received a resetting password email$/
     */
    public function iHaveReceivedResettingPasswordEmail(UserInterface $user): void
    {
        $this->prepareUserPasswordResetToken($user);
    }

    private function prepareUserPasswordResetToken(UserInterface $user): void
    {
        $token = 'itotallyforgotmypassword';

        $user->setPasswordResetToken($token);
        $user->setPasswordRequestedAt(new \DateTime());

        $this->userManager->flush();
    }
}
