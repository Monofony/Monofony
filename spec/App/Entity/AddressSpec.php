<?php

namespace spec\App\Entity;

use App\Entity\Address;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sylius\Component\Resource\Model\ResourceInterface;

class AddressSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Address::class);
    }

    function it_implements_resource_interface()
    {
        $this->shouldImplement(ResourceInterface::class);
    }

    function it_has_no_street_by_default(): void
    {
        $this->getStreet()->shouldReturn(null);
    }

    function its_street_is_mutable()
    {
        $this->setStreet('11 rue de la préfecture');
        $this->getStreet()->shouldReturn('11 rue de la préfecture');
    }

    function it_has_no_postcode_by_default(): void
    {
        $this->getPostcode()->shouldReturn(null);
    }

    function its_postcode_is_mutable()
    {
        $this->setPostcode('35000');
        $this->getPostcode()->shouldReturn('35000');
    }

    function it_has_no_city_by_default(): void
    {
        $this->getCity()->shouldReturn(null);
    }

    function its_city_is_mutable()
    {
        $this->setCity('Rennes');
        $this->getCity()->shouldReturn('Rennes');
    }
}
