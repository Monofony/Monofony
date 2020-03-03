<?php

/*
 * This file is part of the Monofony package.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Monofony\Bundle\CoreBundle\DataCollector;

use Monofony\Bundle\CoreBundle\DataCollector\MonofonyDataCollector;
use Monofony\Bundle\CoreBundle\MonofonyCoreBundle;
use PhpSpec\ObjectBehavior;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;

class MonofonyDataCollectorSpec extends ObjectBehavior
{
    function let(): void
    {
        $this->beConstructedWith([]);
    }

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
