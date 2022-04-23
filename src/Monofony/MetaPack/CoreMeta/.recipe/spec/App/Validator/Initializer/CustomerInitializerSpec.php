<?php

declare(strict_types=1);

namespace spec\App\Validator\Initializer;

use App\Validator\Initializer\CustomerInitializer;
use PhpSpec\ObjectBehavior;
use Sylius\Component\Customer\Model\CustomerInterface;
use Sylius\Component\User\Canonicalizer\CanonicalizerInterface;
use Symfony\Component\Validator\ObjectInitializerInterface;

final class CustomerInitializerSpec extends ObjectBehavior
{
    function let(CanonicalizerInterface $canonicalizer): void
    {
        $this->beConstructedWith($canonicalizer);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(CustomerInitializer::class);
    }

    function it_implements_symfony_validator_initializer_interface(): void
    {
        $this->shouldImplement(ObjectInitializerInterface::class);
    }

    function it_sets_canonical_email_when_initializing_customer(
        CanonicalizerInterface $canonicalizer,
        CustomerInterface $customer,
    ): void {
        $customer->getEmail()->willReturn('sTeFfEn@gMaiL.CoM');
        $canonicalizer->canonicalize('sTeFfEn@gMaiL.CoM')->willReturn('steffen@gmail.com');
        $customer->setEmailCanonical('steffen@gmail.com')->shouldBeCalled();

        $this->initialize($customer);
    }

    function it_does_not_set_canonical_email_when_initializing_non_customer_object(\stdClass $object): void
    {
        $this->initialize($object);
    }
}
