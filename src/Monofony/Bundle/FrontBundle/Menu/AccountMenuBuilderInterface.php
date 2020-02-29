<?php

declare(strict_types=1);

namespace Monofony\Bundle\FrontBundle\Menu;

use Knp\Menu\ItemInterface;

interface AccountMenuBuilderInterface
{
    public function createMenu(array $options): ItemInterface;
}
