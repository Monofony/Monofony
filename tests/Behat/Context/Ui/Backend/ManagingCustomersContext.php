<?php

/*
 * This file is part of AppName.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Tests\Behat\Context\Ui\Backend;

use Behat\Behat\Context\Context;
use App\Tests\Behat\Page\Backend\Customer\IndexPage;
use App\Tests\Behat\Page\Backend\Customer\UpdatePage;
use App\Tests\Behat\Service\Resolver\CurrentPageResolverInterface;
use App\Entity\Customer\CustomerInterface;
use Webmozart\Assert\Assert;

final class ManagingCustomersContext implements Context
{
    /**
     * @var IndexPage
     */
    private $indexPage;

    /**
     * @var UpdatePage
     */
    private $updatePage;

    /**
     * @var CurrentPageResolverInterface
     */
    private $currentPageResolver;

    /**
     * @param IndexPage                    $indexPage
     * @param UpdatePage                   $updatePage
     * @param CurrentPageResolverInterface $currentPageResolver
     */
    public function __construct(
        IndexPage $indexPage,
        UpdatePage $updatePage,
        CurrentPageResolverInterface $currentPageResolver
    ) {
        $this->indexPage = $indexPage;
        $this->updatePage = $updatePage;
        $this->currentPageResolver = $currentPageResolver;
    }

    /**
     * @When I change their email to :email
     * @When I remove its email
     */
    public function iChangeTheirEmailTo(?string $email = null): void
    {
        $this->updatePage->changeEmail($email);
    }

    /**
     * @When I change their first name to :firstName
     * @When I remove its first name
     */
    public function iChangeTheirFirstNameTo(?string $firstName = null): void
    {
        $this->updatePage->changeFirstName($firstName);
    }

    /**
     * @When I change their last name to :lastName
     * @When I remove its last name
     */
    public function iChangeTheirLastNameTo(?string $lastName = null): void
    {
        $this->updatePage->changeLastName($lastName);
    }

    /**
     * @Then the customer :customer should appear in the store
     * @Then the customer :customer should still have this email
     */
    public function theCustomerShould(CustomerInterface $customer): void
    {
        $this->indexPage->open();

        Assert::true($this->indexPage->isSingleResourceOnPage(['email' => $customer->getEmail()]));
    }

    /**
     * @When /^I want to edit (this customer)$/
     */
    public function iWantToEditThisCustomer(CustomerInterface $customer): void
    {
        $this->updatePage->open(['id' => $customer->getId()]);
    }

    /**
     * @When I save my changes
     * @When I try to save my changes
     */
    public function iSaveMyChanges(): void
    {
        $this->updatePage->saveChanges();
    }

    /**
     * @Then /^(this customer) with name "([^"]*)" should appear in the store$/
     */
    public function theCustomerWithNameShouldAppearInTheRegistry(CustomerInterface $customer, $name): void
    {
        $this->updatePage->open(['id' => $customer->getId()]);

        Assert::same($this->updatePage->getFullName(), $name);
    }

    /**
     * @When I want to see all customers in store
     */
    public function iWantToSeeAllCustomersInStore(): void
    {
        $this->indexPage->open();
    }

    /**
     * @Then /^I should see (\d+) customers in the list$/
     */
    public function iShouldSeeCustomersInTheList($amountOfCustomers): void
    {
        Assert::same($this->indexPage->countItems(), (int) $amountOfCustomers);
    }

    /**
     * @Then I should see the customer :email in the list
     */
    public function iShouldSeeTheCustomerInTheList($email): void
    {
        Assert::true($this->indexPage->isSingleResourceOnPage(['email' => $email]));
    }

    /**
     * @Then /^I should be notified that ([^"]+) should be ([^"]+)$/
     */
    public function iShouldBeNotifiedThatTheElementShouldBe($elementName, $validationMessage): void
    {
        Assert::same(
            $this->updatePage->getValidationMessage($elementName),
            sprintf('%s must be %s.', ucfirst($elementName), $validationMessage)
        );
    }

    /**
     * @Then the customer with email :email should not appear in the store
     */
    public function theCustomerShouldNotAppearInTheStore($email): void
    {
        $this->indexPage->open();

        Assert::false($this->indexPage->isSingleResourceOnPage(['email' => $email]));
    }

    /**
     * @Then /^(this customer) should have an empty first name$/
     * @Then the customer :customer should still have an empty first name
     */
    public function theCustomerShouldStillHaveAnEmptyFirstName(CustomerInterface $customer): void
    {
        $this->updatePage->open(['id' => $customer->getId()]);

        Assert::eq($this->updatePage->getFirstName(), '');
    }

    /**
     * @Then /^(this customer) should have an empty last name$/
     * @Then the customer :customer should still have an empty last name
     */
    public function theCustomerShouldStillHaveAnEmptyLastName(CustomerInterface $customer): void
    {
        $this->updatePage->open(['id' => $customer->getId()]);

        Assert::eq($this->updatePage->getLastName(), '');
    }

    /**
     * @Then there should still be only one customer with email :email
     */
    public function thereShouldStillBeOnlyOneCustomerWithEmail($email): void
    {
        $this->indexPage->open();

        Assert::true($this->indexPage->isSingleResourceOnPage(['email' => $email]));
    }

    /**
     * @Given I want to enable :customer
     * @Given I want to disable :customer
     */
    public function iWantToChangeStatusOf(CustomerInterface $customer): void
    {
        $this->updatePage->open(['id' => $customer->getId()]);
    }

    /**
     * @When I enable their account
     */
    public function iEnableIt(): void
    {
        $this->updatePage->enable();
    }

    /**
     * @When I disable their account
     */
    public function iDisableIt(): void
    {
        $this->updatePage->disable();
    }

    /**
     * @Then /^(this customer) should be enabled$/
     */
    public function thisCustomerShouldBeEnabled(CustomerInterface $customer): void
    {
        $this->indexPage->open();

        Assert::eq($this->indexPage->getCustomerAccountStatus($customer), 'Enabled');
    }

    /**
     * @Then /^(this customer) should be disabled$/
     */
    public function thisCustomerShouldBeDisabled(CustomerInterface $customer): void
    {
        $this->indexPage->open();

        Assert::eq($this->indexPage->getCustomerAccountStatus($customer), 'Disabled');
    }

    /**
     * @Then the customer :customer should have an account created
     * @Then /^(this customer) should have an account created$/
     */
    public function theyShouldHaveAnAccountCreated(CustomerInterface $customer): void
    {
        Assert::notNull(
            $customer->getUser()->getPassword(),
            'Customer should have an account, but they do not.'
        );
    }

    /**
     * @When I make them subscribed to the newsletter
     */
    public function iMakeThemSubscribedToTheNewsletter(): void
    {
        $this->updatePage->subscribeToTheNewsletter();
    }

    /**
     * @When I change the password of user :customer to :newPassword
     */
    public function iChangeThePasswordOfUserTo(CustomerInterface $customer, $newPassword): void
    {
        $this->updatePage->open(['id' => $customer->getId()]);
        $this->updatePage->changePassword($newPassword);
        $this->updatePage->saveChanges();
    }

    /**
     * @Then this customer should be subscribed to the newsletter
     */
    public function thisCustomerShouldBeSubscribedToTheNewsletter(): void
    {
        Assert::true($this->updatePage->isSubscribedToTheNewsletter());
    }

    /**
     * @Then I should see the order with number :orderNumber in the list
     */
    public function iShouldSeeASingleOrderFromCustomer($orderNumber): void
    {
        Assert::true($this->indexPage->isSingleResourceOnPage(['number' => $orderNumber]));
    }

    /**
     * @Then I should not see the order with number :orderNumber in the list
     */
    public function iShouldNotSeeASingleOrderFromCustomer($orderNumber): void
    {
        Assert::false($this->indexPage->isSingleResourceOnPage(['number' => $orderNumber]));
    }

    /**
     * @When I do not specify any information
     */
    public function iDoNotSpecifyAnyInformation(): void
    {
        // Intentionally left blank.
    }

    /**
     * @When I do not choose create account option
     */
    public function iDoNotChooseCreateAccountOption(): void
    {
        // Intentionally left blank.
    }
}
