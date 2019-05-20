<?php

namespace spec\App\Form\Extension;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DateTypeExtensionSpec extends ObjectBehavior
{
    function it_extends_an_abstract_type_extension()
    {
        $this->shouldHaveType(AbstractTypeExtension::class);
    }

    function it_extends_date_type()
    {
        $this::getExtendedTypes()->shouldReturn([DateType::class]);
    }

    function it_configures_options(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'widget' => 'single_text',
            'html5' => false,
            'format' => 'dd/MM/yyyy',
        ])->shouldBeCalled();

        $this->configureOptions($resolver);
    }
}
