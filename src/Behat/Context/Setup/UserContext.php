<?php

/*
 * This file is part of AppName.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Behat\Context\Setup;

use App\Behat\Service\SharedStorageInterface;
use App\Entity\AppUser;
use App\Fixture\Factory\AppUserExampleFactory;
use App\Fixture\Factory\ExampleFactoryInterface;
use Behat\Behat\Context\Context;
use Doctrine\Common\Persistence\ObjectManager;
use Sylius\Component\User\Model\UserInterface;
use Sylius\Component\User\Repository\UserRepositoryInterface;

class UserContext implements Context
{
    /**
     * @var SharedStorageInterface
     */
    private $sharedStorage;

    /**
     * @var UserRepositoryInterface
     */
    private $appUserRepository;

    /**
     * @var AppUserExampleFactory
     */
    private $userFactory;

    /**
     * @var ObjectManager
     */
    private $userManager;

    /**
     * @param SharedStorageInterface  $sharedStorage
     * @param UserRepositoryInterface $appUserRepository
     * @param AppUserExampleFactory   $userFactory
     * @param ObjectManager           $appUserManager
     */
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
    public function thereIsUserIdentifiedBy($email, $password = 'sylius')
    {
        $user = $this->userFactory->create(['email' => $email, 'password' => $password, 'enabled' => true]);

        $this->sharedStorage->set('user', $user);

        $this->appUserRepository->add($user);
    }

    /**
     * @Given the account of :email was deleted
     * @Given my account :email was deleted
     */
    public function accountWasDeleted($email)
    {
        /** @var AppUser $user */
        $user = $this->appUserRepository->findOneByEmail($email);

        $this->sharedStorage->set('customer', $user->getCustomer());

        $this->appUserRepository->remove($user);
    }

    /**
     * @Given /^(?:(I) have|(this user) has) already received a resetting password email$/
     */
    public function iHaveReceivedResettingPasswordEmail(UserInterface $user)
    {
        $this->prepareUserPasswordResetToken($user);
    }

    /**
     * @param UserInterface $user
     */
    private function prepareUserPasswordResetToken(UserInterface $user)
    {
        $token = 'itotallyforgotmypassword';

        $user->setPasswordResetToken($token);
        $user->setPasswordRequestedAt(new \DateTime());

        $this->userManager->flush();
    }
}
