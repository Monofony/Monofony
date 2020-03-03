<?php

namespace spec\Monofony\Bundle\CoreBundle\DataCollector;

use Monofony\Bundle\CoreBundle\DataCollector\MonofonyDataCollector;
use Monofony\Bundle\CoreBundle\MonofonyCoreBundle;
use PhpSpec\ObjectBehavior;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;

class MonofonyDataCollectorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(MonofonyDataCollector::class);
    }

    function it_is_a_data_collector(): void
    {
        $this->shouldHaveType(DataCollector::class);
    }

    function it_can_get_version(): void
    {
        $this->getVersion()->shouldReturn(MonofonyCoreBundle::VERSION);
    }
}
