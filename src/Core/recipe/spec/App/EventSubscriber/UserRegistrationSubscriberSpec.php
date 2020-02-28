<?php

declare(strict_types=1);

namespace spec\App\EventSubscriber;

use Monofony\Component\Core\Model\Customer\CustomerInterface;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Events;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sylius\Bundle\UserBundle\UserEvents;
use Sylius\Component\User\Model\UserInterface;
use Sylius\Component\User\Security\Generator\GeneratorInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

final class UserRegistrationSubscriberSpec extends ObjectBehavior
{
    function let(
        ObjectManager $userManager,
        GeneratorInterface $tokenGenerator,
        EventDispatcherInterface $eventDispatcher
    ): void {
        $this->beConstructedWith(
            $userManager,
            $tokenGenerator,
            $eventDispatcher
        );
    }

    function it_is_a_subscriber(): void
    {
        $this->shouldImplement(EventSubscriberInterface::class);
    }

    function it_subscribes_to_events(): void
    {
        $this::getSubscribedEvents()->shouldReturn([
            'sylius.customer.post_register' => 'handleUserVerification',
        ]);
    }

    function it_sends_an_user_verification_email(
        ObjectManager $userManager,
        GeneratorInterface $tokenGenerator,
        EventDispatcherInterface $eventDispatcher,
        GenericEvent $event,
        CustomerInterface $customer,
        UserInterface $user
    ): void {
        $event->getSubject()->willReturn($customer);
        $customer->getUser()->willReturn($user);

        $tokenGenerator->generate()->willReturn('1d7dbc5c3dbebe5c');
        $user->setEmailVerificationToken('1d7dbc5c3dbebe5c')->shouldBeCalled();

        $userManager->persist($user)->shouldBeCalled();
        $userManager->flush()->shouldBeCalled();

        $eventDispatcher
            ->dispatch(Argument::type(GenericEvent::class), UserEvents::REQUEST_VERIFICATION_TOKEN)
            ->shouldBeCalled()
        ;

        $this->handleUserVerification($event);
    }

    function it_throws_an_invalid_argument_exception_if_event_subject_is_not_customer_type(
        GenericEvent $event,
        \stdClass $customer
    ): void {
        $event->getSubject()->willReturn($customer);

        $this->shouldThrow(\InvalidArgumentException::class)->during('handleUserVerification', [$event]);
    }

    function it_throws_an_invalid_argument_exception_if_user_is_null(
        GenericEvent $event,
        CustomerInterface $customer
    ): void {
        $event->getSubject()->willReturn($customer);
        $customer->getUser()->willReturn(null);

        $this->shouldThrow(\InvalidArgumentException::class)->during('handleUserVerification', [$event]);
    }
}
