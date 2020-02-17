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

namespace App\Tests\Behat\Page\Backend;

use App\Tests\Behat\Service\Accessor\TableAccessorInterface;
use Behat\Mink\Session;
use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;
use Symfony\Component\Routing\RouterInterface;

class DashboardPage extends SymfonyPage
{
    /** @var TableAccessorInterface */
    private $tableAccessor;

    public function __construct(
        Session $session,
        $minkParameters,
        RouterInterface $router,
        TableAccessorInterface $tableAccessor
    ) {
        parent::__construct($session, $minkParameters, $router);

        $this->tableAccessor = $tableAccessor;
    }

    public function getRouteName(): string
    {
        return 'app_backend_dashboard';
    }

    public function getNumberOfNewCustomersInTheList(): int
    {
        return $this->tableAccessor->countTableBodyRows($this->getElement('customer_list'));
    }

    public function getNumberOfNewCustomers(): int
    {
        return (int) $this->getElement('new_customers')->getText();
    }

    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'customer_list' => '#customers',
            'new_customers' => '#new-customers',
        ]);
    }
}
