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
    private $userRepository;

    /**
     * @var ExampleFactoryInterface
     */
    private $userFactory;

    /**
     * @var ObjectManager
     */
    private $userManager;

    /**
     * @param SharedStorageInterface  $sharedStorage
     * @param UserRepositoryInterface $userRepository
     * @param ExampleFactoryInterface $userFactory
     * @param ObjectManager           $userManager
     */
    public function __construct(
        SharedStorageInterface $sharedStorage,
        UserRepositoryInterface $userRepository,
        ExampleFactoryInterface $userFactory,
        ObjectManager $userManager
    ) {
        $this->sharedStorage = $sharedStorage;
        $this->userRepository = $userRepository;
        $this->userFactory = $userFactory;
        $this->userManager = $userManager;
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

        $this->userRepository->add($user);
    }

    /**
     * @Given the account of :email was deleted
     * @Given my account :email was deleted
     */
    public function accountWasDeleted($email)
    {
        /** @var AppUser $user */
        $user = $this->userRepository->findOneByEmail($email);

        $this->sharedStorage->set('customer', $user->getCustomer());

        $this->userRepository->remove($user);
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
