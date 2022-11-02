<?php

namespace spec\App\Form\Extension;

use App\Form\EventSubscriber\AddUserFormSubscriber;
use App\Form\Type\User\AppUserType;
use PhpSpec\ObjectBehavior;
use Sylius\Bundle\CustomerBundle\Form\Type\CustomerType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;

final class CustomerTypeExtensionSpec extends ObjectBehavior
{
    function it_extends_an_abstract_type_extension()
    {
        $this->shouldHaveType(AbstractTypeExtension::class);
    }

    function it_extends_customer_type()
    {
        $this::getExtendedTypes()->shouldReturn([CustomerType::class]);
    }

    function it_adds_user_form_subscriber(FormBuilderInterface $builder)
    {
        $builder->addEventSubscriber(new AddUserFormSubscriber(AppUserType::class))->willReturn($builder)->shouldBeCalled();

        $this->buildForm($builder, []);
    }
}
