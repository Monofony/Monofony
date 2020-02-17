<?php

namespace spec\App\Collector;

use App\Collector\AppCollector;
use App\Kernel;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;

class AppCollectorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(AppCollector::class);
    }

    function it_is_a_data_collector(): void
    {
        $this->shouldHaveType(DataCollector::class);
    }

    function it_can_get_version(): void
    {
        $this->getVersion()->shouldReturn(Kernel::VERSION);
    }
}
