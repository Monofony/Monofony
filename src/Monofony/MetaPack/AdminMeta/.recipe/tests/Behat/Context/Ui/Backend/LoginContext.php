<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context\Ui\Backend;

use App\Tests\Behat\Page\Backend\Account\LoginPage;
use App\Tests\Behat\Page\Backend\DashboardPage;
use Behat\Behat\Context\Context;
use Webmozart\Assert\Assert;

class LoginContext implements Context
{
    private $dashboardPage;
    private $loginPage;

    public function __construct(DashboardPage $dashboardPage, LoginPage $loginPage)
    {
        $this->dashboardPage = $dashboardPage;
        $this->loginPage = $loginPage;
    }

    /**
     * @Then I should be able to log in as :username authenticated by :password password
     */
    public function iShouldBeAbleToLogInAsAuthenticatedByPassword($username, $password)
    {
        $this->logInAgain($username, $password);

        $this->dashboardPage->verify();
    }

    /**
     * @Then I should not be able to log in as :username authenticated by :password password
     */
    public function iShouldNotBeAbleToLogInAsAuthenticatedByPassword($username, $password)
    {
        $this->logInAgain($username, $password);

        Assert::true($this->loginPage->hasValidationErrorWith('Error Invalid credentials.'));
        Assert::false($this->dashboardPage->isOpen());
    }

    /**
     * @Then I visit login page
     */
    public function iVisitLoginPage()
    {
        $this->loginPage->open();
    }

    private function logInAgain(string $username, string $password): void
    {
        $this->dashboardPage->open();
        $this->dashboardPage->logOut();

        $this->loginPage->open();
        $this->loginPage->specifyUsername($username);
        $this->loginPage->specifyPassword($password);
        $this->loginPage->logIn();
    }
}
