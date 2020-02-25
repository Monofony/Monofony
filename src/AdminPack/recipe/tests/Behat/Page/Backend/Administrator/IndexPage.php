<?php

declare(strict_types=1);

namespace App\Tests\Behat\Page\Backend\Administrator;

use App\Tests\Behat\Page\Backend\Crud\AbstractIndexPage;

class IndexPage extends AbstractIndexPage
{
    /**
     * {@inheritdoc}
     */
    public function getRouteName(): string
    {
        return 'sylius_backend_admin_user_index';
    }
}
