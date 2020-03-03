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

namespace Monofony\Bundle\AdminBundle;

use Monofony\Bundle\AdminBundle\DependencyInjection\MonofonyAdminBundleExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class MonofonyAdminBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new MonofonyAdminBundleExtension();
    }
}
