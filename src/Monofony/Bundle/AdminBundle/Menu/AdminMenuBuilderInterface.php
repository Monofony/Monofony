<?php

declare(strict_types=1);

namespace Monofony\Bundle\AdminBundle\Menu;

use Knp\Menu\ItemInterface;

interface AdminMenuBuilderInterface
{
    public function createMenu(array $options): ItemInterface;
}
