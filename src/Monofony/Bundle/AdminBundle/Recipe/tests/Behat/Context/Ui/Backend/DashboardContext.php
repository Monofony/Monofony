<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context\Ui\Backend;

use App\Tests\Behat\Page\Backend\DashboardPage;
use Behat\Behat\Context\Context;
use Webmozart\Assert\Assert;

class DashboardContext implements Context
{
    private $dashboardPage;

    public function __construct(DashboardPage $dashboardPage)
    {
        $this->dashboardPage = $dashboardPage;
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
    public function iShouldSeeNewCustomersInTheList($number)
    {
        Assert::same($this->dashboardPage->getNumberOfNewCustomersInTheList(), (int) $number);
    }

    /**
     * @Then I should see :number new customers
     */
    public function iShouldSeeNewCustomers($number)
    {
        Assert::same($this->dashboardPage->getNumberOfNewCustomers(), (int) $number);
    }
}
