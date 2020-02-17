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

namespace spec\App\Context;

use App\Entity\Customer\CustomerInterface;
use App\Entity\User\AppUserInterface;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

final class CustomerContextSpec extends ObjectBehavior
{
    function let(TokenStorageInterface $tokenStorage, AuthorizationCheckerInterface $authorizationChecker): void
    {
        $this->beConstructedWith($tokenStorage, $authorizationChecker);
    }

    function it_gets_customer_from_currently_logged_user(
        TokenStorageInterface $tokenStorage,
        AuthorizationCheckerInterface $authorizationChecker,
        TokenInterface $token,
        AppUserInterface $user,
        CustomerInterface $customer
    ): void {
        $tokenStorage->getToken()->willReturn($token);
        $authorizationChecker->isGranted('IS_AUTHENTICATED_REMEMBERED')->willReturn(true);
        $token->getUser()->willReturn($user);
        $user->getCustomer()->willReturn($customer);

        $this->getCustomer()->shouldReturn($customer);
    }

    function it_returns_null_if_user_is_not_logged_in($tokenStorage): void
    {
        $tokenStorage->getToken()->willReturn(null);

        $this->getCustomer()->shouldReturn(null);
    }

    function it_returns_null_if_user_is_not_an_user_instance(
        TokenStorageInterface $tokenStorage,
        AuthorizationCheckerInterface $authorizationChecker,
        TokenInterface $token,
        \stdClass $user
    ): void {
        $tokenStorage->getToken()->willReturn($token);
        $authorizationChecker->isGranted('IS_AUTHENTICATED_REMEMBERED')->willReturn(true);
        $token->getUser()->willReturn($user);

        $this->getCustomer()->shouldReturn(null);
    }
}
