<?php

namespace spec\App\Entity\User;

use Monofony\Component\Core\Model\User\AppUserInterface;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Customer\Model\CustomerInterface;
use Sylius\Component\Resource\Exception\UnexpectedTypeException;
use Sylius\Component\User\Model\User as BaseUser;

class AppUserSpec extends ObjectBehavior
{
    function it_implements_an_app_user_interface(): void
    {
        $this->shouldImplement(AppUserInterface::class);
    }

    function it_extends_a_user_model(): void
    {
        $this->shouldHaveType(BaseUser::class);
    }

    function it_has_no_customer_by_default()
    {
        $this->getCustomer()->shouldReturn(null);
    }

    function its_customer_is_mutable(CustomerInterface $customer)
    {
        $this->setCustomer($customer);
        $this->getCustomer()->shouldReturn($customer);
    }

    function it_sets_customer_email(CustomerInterface $customer): void
    {
        $customer->setEmail('jon@snow.wall')->shouldBeCalled();

        $this->setCustomer($customer);

        $this->setEmail('jon@snow.wall');
    }

    function it_returns_customer_email(CustomerInterface $customer): void
    {
        $customer->getEmail()->willReturn('jon@snow.wall');

        $this->setCustomer($customer);

        $this->getEmail()->shouldReturn('jon@snow.wall');
    }

    function it_returns_null_as_customer_email_if_no_customer_is_assigned(): void
    {
        $this->getEmail()->shouldReturn(null);
    }

    function it_throws_an_exception_if_trying_to_set_email_while_no_customer_is_assigned(): void
    {
        $this->shouldThrow(UnexpectedTypeException::class)->during('setEmail', ['jon@snow.wall']);
    }

    function it_returns_customer_email_canonical(CustomerInterface $customer): void
    {
        $customer->getEmailCanonical()->willReturn('jon@snow.wall');

        $this->setCustomer($customer);

        $this->getEmailCanonical()->shouldReturn('jon@snow.wall');
    }

    function it_sets_customer_email_canonical(CustomerInterface $customer): void
    {
        $customer->setEmailCanonical('jon@snow.wall')->shouldBeCalled();

        $this->setCustomer($customer);

        $this->setEmailCanonical('jon@snow.wall');
    }

    function it_throws_an_exception_if_trying_to_set_email_canonical_while_no_customer_is_assigned(): void
    {
        $this->shouldThrow(UnexpectedTypeException::class)->during('setEmailCanonical', ['jon@snow.wall']);
    }
}
