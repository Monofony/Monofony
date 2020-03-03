<?php

/*
 * This file is part of the Monofony package.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Monofony\Bundle\FrontBundle;

use Monofony\Bundle\FrontBundle\DependencyInjection\MonofonyFrontBundleExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class MonofonyFrontBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new MonofonyFrontBundleExtension();
    }
}
