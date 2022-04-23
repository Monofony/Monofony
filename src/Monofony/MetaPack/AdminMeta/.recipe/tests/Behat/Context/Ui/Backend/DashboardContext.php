<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context\Ui\Backend;

use App\Tests\Behat\Page\Backend\DashboardPage;
use Behat\Behat\Context\Context;
use Webmozart\Assert\Assert;

class DashboardContext implements Context
{
    public function __construct(private DashboardPage $dashboardPage)
    {
    }

    /**
     * @When I open administration dashboard
     */
    public function iOpenAdministrationDashboard()
    {
        $this->dashboardPage->open();
    }

    /**
     * @Then I should see :number new customers in the list
     */
    public function iShouldSeeNewCustomersInTheList(int $number)
    {
        Assert::same($this->dashboardPage->getNumberOfNewCustomersInTheList(), $number);
    }

    /**
     * @Then I should see :number new customers
     */
    public function iShouldSeeNewCustomers(int $number)
    {
        Assert::same($this->dashboardPage->getNumberOfNewCustomers(), $number);
    }
}
