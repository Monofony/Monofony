<?php

declare(strict_types=1);

namespace App\Tests\Behat\Page\Backend\Administrator;

use Monofony\Bridge\Behat\Crud\AbstractIndexPage;
use Monofony\Bridge\Behat\Crud\IndexPageInterface;

class IndexPage extends AbstractIndexPage implements IndexPageInterface
{
    public function getRouteName(): string
    {
        return 'sylius_backend_admin_user_index';
    }
}
