<?php

declare(strict_types=1);

namespace App\Tests\Behat\Page\Backend;

use Behat\Mink\Session;
use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;
use Monofony\Bridge\Behat\Service\Accessor\TableAccessorInterface;
use Symfony\Component\Routing\RouterInterface;

class DashboardPage extends SymfonyPage
{
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

    public function logOut(): void
    {
        $this->getElement('logout')->click();
    }

    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'customer_list' => '#customers',
            'logout' => '#sylius-logout-button',
            'new_customers' => '#new-customers',
        ]);
    }
}
