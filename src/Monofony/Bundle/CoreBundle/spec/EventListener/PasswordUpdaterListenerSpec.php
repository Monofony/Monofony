<?php

/*
 * This file is part of the Monofony package.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace spec\Monofony\Bundle\CoreBundle\EventListener;

use Monofony\Component\Core\Model\Customer\CustomerInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\User\Model\UserInterface;
use Sylius\Component\User\Security\PasswordUpdaterInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

final class PasswordUpdaterListenerSpec extends ObjectBehavior
{
    function let(PasswordUpdaterInterface $passwordUpdater): void
    {
        $this->beConstructedWith($passwordUpdater);
    }

    function it_updates_password_for_customer(
        PasswordUpdaterInterface $passwordUpdater,
        GenericEvent $event,
        UserInterface $user,
        CustomerInterface $customer
    ): void {
        $event->getSubject()->willReturn($customer);
        $customer->getUser()->willReturn($user);
        $user->getPlainPassword()->willReturn('password123');

        $passwordUpdater->updatePassword($user)->shouldBeCalled();

        $this->customerUpdateEvent($event);
    }

    function it_does_not_update_password_if_subject_is_not_instance_of_customer_interface(
        GenericEvent $event,
        UserInterface $user
    ): void {
        $event->getSubject()->willReturn($user);

        $this->shouldThrow(\InvalidArgumentException::class)->during('customerUpdateEvent', [$event]);
    }

    function it_does_not_update_password_if_customer_does_not_have_user(
        PasswordUpdaterInterface $passwordUpdater,
        GenericEvent $event,
        CustomerInterface $customer
    ): void {
        $event->getSubject()->willReturn($customer);
        $customer->getUser()->willReturn(null);

        $passwordUpdater->updatePassword(null)->shouldNotBeCalled();

        $this->customerUpdateEvent($event);
    }
}
