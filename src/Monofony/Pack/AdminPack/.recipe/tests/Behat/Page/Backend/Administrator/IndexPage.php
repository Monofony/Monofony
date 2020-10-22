<?php

declare(strict_types=1);

namespace App\Tests\Behat\Page\Backend\Administrator;

use Monofony\Component\Admin\Behat\Crud\AbstractIndexPage;
use Monofony\Component\Admin\Behat\Crud\IndexPageInterface;

class IndexPage extends AbstractIndexPage implements IndexPageInterface
{
    /**
     * {@inheritdoc}
     */
    public function getRouteName(): string
    {
        return 'sylius_backend_admin_user_index';
    }
}
