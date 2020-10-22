<?php

namespace spec\App\Message;

use App\Message\RegisterAppUser;
use PhpSpec\ObjectBehavior;

class RegisterAppUserSpec extends ObjectBehavior
{
    function let(): void
    {
        $this->beConstructedWith(
            'inigo.montoya@prepare-to-die.com',
            'You killed my father',
            'Inigo',
            'Montoya',
            '0203040506'
        );
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(RegisterAppUser::class);
    }

    function it_can_get_first_name(): void
    {
        $this->firstName->shouldReturn('Inigo');
    }

    function it_can_get_last_name(): void
    {
        $this->lastName->shouldReturn('Montoya');
    }

    function it_can_get_email(): void
    {
        $this->email->shouldReturn('inigo.montoya@prepare-to-die.com');
    }

    function it_can_get_password(): void
    {
        $this->password->shouldReturn('You killed my father');
    }

    function it_can_get_phone_number(): void
    {
        $this->phoneNumber->shouldReturn('0203040506');
    }
}
