<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context\Ui\Backend;

use App\Tests\Behat\Page\Backend\Customer\IndexPage;
use App\Tests\Behat\Page\Backend\Customer\ShowPage;
use App\Tests\Behat\Page\Backend\Customer\UpdatePage;
use Behat\Behat\Context\Context;
use Monofony\Contracts\Core\Model\Customer\CustomerInterface;
use Webmozart\Assert\Assert;

final class ManagingCustomersContext implements Context
{
    public function __construct(
        private IndexPage $indexPage,
        private UpdatePage $updatePage,
        private ShowPage $showPage,
    ) {
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
     * @Then /^(this customer) with name "([^"]*)" should appear in the list$/
     */
    public function theCustomerWithNameShouldAppearInTheList(CustomerInterface $customer, $name): void
    {
        $this->updatePage->open(['id' => $customer->getId()]);

        Assert::same($this->updatePage->getFullName(), $name);
    }

    /**
     * @When I want to see all customers in the admin panel
     * @When I am browsing customers
     */
    public function iWantToSeeAllCustomersInTheAdminPanel(): void
    {
        $this->indexPage->open();
    }

    /**
     * @When I view details of the customer :customer
     */
    public function iViewDetailsOfTheCustomer(CustomerInterface $customer): void
    {
        $this->showPage->open(['id' => $customer->getId()]);
    }

    /**
     * @When I start sorting customers by :field
     */
    public function iStartSortingCustomersBy(string $field): void
    {
        $this->indexPage->sortBy($field);
    }

    /**
     * @Then I should see :amount customers in the list
     */
    public function iShouldSeeCustomersInTheList(int $amount): void
    {
        Assert::same($this->indexPage->countItems(), $amount);
    }

    /**
     * @Then the first customer in the list should have :field :value
     */
    public function theFirstCustomerInTheListShouldHave(string $field, string $value): void
    {
        Assert::same($this->indexPage->getColumnFields($field)[0], $value);
    }

    /**
     * @Then the last customer in the list should have :field :value
     */
    public function theLastCustomerInTheListShouldHave(string $field, string $value): void
    {
        $values = $this->indexPage->getColumnFields($field);

        Assert::same(end($values), $value);
    }

    /**
     * @Then his name should be :name
     */
    public function hisNameShouldBe(string $name): void
    {
        Assert::same($this->showPage->getCustomerName(), $name);
    }

    /**
     * @Then he should be registered since :registrationDate
     */
    public function hisRegistrationDateShouldBe(string $registrationDate): void
    {
        Assert::eq($this->showPage->getRegistrationDate(), new \DateTime($registrationDate));
    }

    /**
     * @Then his email should be :email
     */
    public function hisEmailShouldBe(string $email): void
    {
        Assert::same($this->showPage->getCustomerEmail(), $email);
    }

    /**
     * @Then his phone number should be :phoneNumber
     */
    public function hisPhoneNumberShouldBe(string $phoneNumber): void
    {
        Assert::same($this->showPage->getCustomerPhoneNumber(), $phoneNumber);
    }

    /**
     * @Then I should see the customer :email in the list
     */
    public function iShouldSeeTheCustomerInTheList(string $email): void
    {
        Assert::true($this->indexPage->isSingleResourceOnPage(['email' => $email]));
    }

    /**
     * @Then /^I should be notified that ([^"]+) should be ([^"]+)$/
     */
    public function iShouldBeNotifiedThatTheElementShouldBe(string $elementName, string $validationMessage): void
    {
        Assert::same(
            $this->updatePage->getValidationMessage($elementName),
            sprintf('%s must be %s.', ucfirst($elementName), $validationMessage)
        );
    }

    /**
     * @Then the customer with email :email should not appear in the store
     */
    public function theCustomerShouldNotAppearInTheStore(string $email): void
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
    public function thereShouldStillBeOnlyOneCustomerWithEmail(string $email): void
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
