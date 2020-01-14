<?php

/*
 * This file is part of AppName.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\EventListener;

use App\Entity\Customer\CustomerInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Sylius\Bundle\UserBundle\UserEvents;
use Sylius\Component\User\Model\UserInterface;
use Sylius\Component\User\Security\Generator\GeneratorInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Webmozart\Assert\Assert;

final class UserRegistrationListener
{
    /**
     * @var ObjectManager
     */
    private $userManager;

    /**
     * @var GeneratorInterface
     */
    private $tokenGenerator;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @param ObjectManager            $userManager
     * @param GeneratorInterface       $tokenGenerator
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(
        ObjectManager $userManager,
        GeneratorInterface $tokenGenerator,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->userManager = $userManager;
        $this->tokenGenerator = $tokenGenerator;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param GenericEvent $event
     */
    public function handleUserVerification(GenericEvent $event): void
    {
        $customer = $event->getSubject();
        Assert::isInstanceOf($customer, CustomerInterface::class);

        $user = $customer->getUser();
        Assert::notNull($user);

        $this->sendVerificationEmail($user);
    }

    /**
     * @param UserInterface $user
     */
    private function sendVerificationEmail(UserInterface $user): void
    {
        $token = $this->tokenGenerator->generate();
        $user->setEmailVerificationToken($token);

        $this->userManager->persist($user);
        $this->userManager->flush();

        $this->eventDispatcher->dispatch(new GenericEvent($user), UserEvents::REQUEST_VERIFICATION_TOKEN);
    }
}
