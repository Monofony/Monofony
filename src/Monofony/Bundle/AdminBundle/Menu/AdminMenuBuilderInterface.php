<?php

/*
 * This file is part of monofony.
 *
 * (c) Mobizel
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Monofony\Bundle\AdminBundle\Menu;

use Knp\Menu\ItemInterface;

interface AdminMenuBuilderInterface
{
    public function createMenu(array $options): ItemInterface;
}
