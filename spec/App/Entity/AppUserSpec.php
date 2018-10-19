<?php

namespace spec\App\Entity;

use App\Entity\AppUser;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Customer\Model\CustomerInterface;
use Sylius\Component\User\Model\User as BaseUser;

class AppUserSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(AppUser::class);
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
}
