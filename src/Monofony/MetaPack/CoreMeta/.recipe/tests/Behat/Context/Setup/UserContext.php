<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context\Setup;

use App\Factory\AppUserFactory;
use Behat\Behat\Context\Context;
use Doctrine\Persistence\ObjectManager;
use Monofony\Bridge\Behat\Service\SharedStorageInterface;
use Monofony\Contracts\Core\Model\User\AppUserInterface;
use Sylius\Component\User\Model\UserInterface;
use Sylius\Component\User\Repository\UserRepositoryInterface;
use Zenstruck\Foundry\Proxy;

class UserContext implements Context
{
    public function __construct(
        private SharedStorageInterface $sharedStorage,
        private UserRepositoryInterface $appUserRepository,
        private AppUserFactory $appUserFactory,
        private ObjectManager $appUserManager,
    ) {
    }

    /**
     * @Given there is a user :email identified by :password
     * @Given there was account of :email with password :password
     * @Given there is a user :email
     */
    public function thereIsUserIdentifiedBy(string $email, string $password = 'sylius'): void
    {
        $user = $this->appUserFactory
            ->createOne(['email' => $email, 'password' => $password, 'enabled' => true])
            ->disableAutoRefresh()
        ;

        $this->sharedStorage->set('user', $user);
    }

    /**
     * @Given the account of :email was deleted
     * @Given my account :email was deleted
     */
    public function accountWasDeleted(string $email): void
    {
        /** @var AppUserInterface $user */
        $user = $this->appUserRepository->findOneByEmail($email);

        $this->sharedStorage->set('customer', $user->getCustomer());

        $this->appUserRepository->remove($user);
    }

    /**
     * @Given /^(?:(I) have|(this user) has) already received a resetting password email$/
     */
    public function iHaveReceivedResettingPasswordEmail(UserInterface|Proxy $user): void
    {
        $this->prepareUserPasswordResetToken($user);
    }

    private function prepareUserPasswordResetToken(UserInterface|Proxy $user): void
    {
        $token = 'itotallyforgotmypassword';

        $user->setPasswordResetToken($token);

        $user->setPasswordRequestedAt(new \DateTime());

        if ($user instanceof Proxy) {
            $user->save();

            return;
        }

        $this->appUserManager->flush();
    }
}
