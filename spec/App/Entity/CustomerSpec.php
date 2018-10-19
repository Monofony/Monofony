<?php

namespace spec\App\Entity;

use App\Entity\AppUser;
use App\Entity\Customer;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Customer\Model\Customer as BaseCustomer;

class CustomerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Customer::class);
    }

    function it_extends_base_customer()
    {
        $this->shouldBeAnInstanceOf(BaseCustomer::class);
    }

    function its_user_is_mutable(AppUser $user)
    {
        $this->setUser($user);
        $this->getUser()->shouldReturn($user);
    }
}
