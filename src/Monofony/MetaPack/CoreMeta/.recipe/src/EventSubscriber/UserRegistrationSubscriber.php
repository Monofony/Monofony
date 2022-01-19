<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use Doctrine\Persistence\ObjectManager;
use Monofony\Contracts\Core\Model\Customer\CustomerInterface;
use Sylius\Bundle\UserBundle\UserEvents;
use Sylius\Component\User\Model\UserInterface;
use Sylius\Component\User\Security\Generator\GeneratorInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Webmozart\Assert\Assert;

final class UserRegistrationSubscriber implements EventSubscriberInterface
{
    public function __construct(private ObjectManager $userManager, private GeneratorInterface $tokenGenerator, private EventDispatcherInterface $eventDispatcher)
    {
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents(): array
    {
        return [
            'sylius.customer.post_register' => 'handleUserVerification',
        ];
    }

    public function handleUserVerification(GenericEvent $event): void
    {
        $customer = $event->getSubject();
        Assert::isInstanceOf($customer, CustomerInterface::class);

        $user = $customer->getUser();
        Assert::notNull($user);

        $this->sendVerificationEmail($user);
    }

    private function sendVerificationEmail(UserInterface $user): void
    {
        $token = $this->tokenGenerator->generate();
        $user->setEmailVerificationToken($token);

        $this->userManager->persist($user);
        $this->userManager->flush();

        $this->eventDispatcher->dispatch(new GenericEvent($user), UserEvents::REQUEST_VERIFICATION_TOKEN);
    }
}
