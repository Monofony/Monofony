<?php

namespace spec\AppBundle\Entity;

use AppBundle\Entity\Address;
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

    function it_sets_street()
    {
        $this->setStreet('11 rue de la préfecture');

        $this->getStreet()->shouldReturn('11 rue de la préfecture');
    }

    function it_sets_postcode()
    {
        $this->setPostcode('35000');

        $this->getPostcode()->shouldReturn('35000');
    }

    function it_sets_city()
    {
        $this->setCity('Rennes');

        $this->getCity()->shouldReturn('Rennes');
    }
}
