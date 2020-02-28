<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context\Ui\Frontend;

use Behat\Behat\Context\Context;
use App\Tests\Behat\NotificationType;
use App\Tests\Behat\Page\Frontend\Account\ChangePasswordPage;
use App\Tests\Behat\Page\Frontend\Account\DashboardPage;
use App\Tests\Behat\Page\Frontend\Account\LoginPage;
use App\Tests\Behat\Page\Frontend\Account\ProfileUpdatePage;
use App\Tests\Behat\Service\NotificationCheckerInterface;
use App\Formatter\StringInflector;
use Webmozart\Assert\Assert;

final class AccountContext implements Context
{
    /**
     * @var DashboardPage
     */
    private $dashboardPage;

    /**
     * @var ProfileUpdatePage
     */
    private $profileUpdatePage;

    /**
     * @var ChangePasswordPage
     */
    private $changePasswordPage;

    /**
     * @var LoginPage
     */
    private $loginPage;

    /**
     * @var NotificationCheckerInterface
     */
    private $notificationChecker;

    /**
     * @param DashboardPage                $dashboardPage
     * @param ProfileUpdatePage            $profileUpdatePage
     * @param ChangePasswordPage           $changePasswordPage
     * @param LoginPage                    $loginPage
     * @param NotificationCheckerInterface $notificationChecker
     */
    public function __construct(
        DashboardPage $dashboardPage,
        ProfileUpdatePage $profileUpdatePage,
        ChangePasswordPage $changePasswordPage,
        LoginPage $loginPage,
        NotificationCheckerInterface $notificationChecker
    ) {
        $this->dashboardPage = $dashboardPage;
        $this->profileUpdatePage = $profileUpdatePage;
        $this->changePasswordPage = $changePasswordPage;
        $this->loginPage = $loginPage;
        $this->notificationChecker = $notificationChecker;
    }

    /**
     * @When I want to modify my profile
     */
    public function iWantToModifyMyProfile(): void
    {
        $this->profileUpdatePage->open();
    }

    /**
     * @When I specify the first name as :firstName
     * @When I remove the first name
     */
    public function iSpecifyTheFirstName($firstName = null): void
    {
        $this->profileUpdatePage->specifyFirstName($firstName);
    }

    /**
     * @When I specify the last name as :lastName
     * @When I remove the last name
     */
    public function iSpecifyTheLastName($lastName = null): void
    {
        $this->profileUpdatePage->specifyLastName($lastName);
    }

    /**
     * @When I specify the customer email as :email
     * @When I remove the customer email
     */
    public function iSpecifyCustomerTheEmail($email = null): void
    {
        $this->profileUpdatePage->specifyEmail($email);
    }

    /**
     * @When I save my changes
     * @When I try to save my changes
     */
    public function iSaveMyChanges(): void
    {
        $this->profileUpdatePage->saveChanges();
    }

    /**
     * @Then I should be notified that it has been successfully edited
     */
    public function iShouldBeNotifiedThatItHasBeenSuccessfullyEdited(): void
    {
        $this->notificationChecker->checkNotification('has been successfully updated.', NotificationType::success());
    }

    /**
     * @Then my name should be :name
     * @Then my name should still be :name
     */
    public function myNameShouldBe($name): void
    {
        $this->dashboardPage->open();

        Assert::true($this->dashboardPage->hasCustomerName($name));
    }

    /**
     * @Then my email should be :email
     * @Then my email should still be :email
     */
    public function myEmailShouldBe($email): void
    {
        $this->dashboardPage->open();

        Assert::true($this->dashboardPage->hasCustomerEmail($email));
    }

    /**
     * @Then /^I should be notified that the (email|password|city|street|first name|last name) is required$/
     */
    public function iShouldBeNotifiedThatElementIsRequired($element): void
    {
        Assert::true($this->profileUpdatePage->checkValidationMessageFor(
            StringInflector::nameToCode($element),
            sprintf('Please enter your %s.', $element)
        ));
    }

    /**
     * @Then /^I should be notified that the (email) is invalid$/
     */
    public function iShouldBeNotifiedThatElementIsInvalid($element): void
    {
        Assert::true($this->profileUpdatePage->checkValidationMessageFor(
            StringInflector::nameToCode($element),
            sprintf('This %s is invalid.', $element)
        ));
    }

    /**
     * @Then I should be notified that the email is already used
     */
    public function iShouldBeNotifiedThatTheEmailIsAlreadyUsed(): void
    {
        Assert::true($this->profileUpdatePage->checkValidationMessageFor('email', 'This email is already used.'));
    }

    /**
     * @Given /^I want to change my password$/
     */
    public function iWantToChangeMyPassword(): void
    {
        $this->changePasswordPage->open();
    }

    /**
     * @Given I change password from :oldPassword to :newPassword
     */
    public function iChangePasswordTo($oldPassword, $newPassword): void
    {
        $this->iSpecifyTheCurrentPasswordAs($oldPassword);
        $this->iSpecifyTheNewPasswordAs($newPassword);
        $this->iSpecifyTheConfirmationPasswordAs($newPassword);
    }

    /**
     * @Then I should be notified that my password has been successfully changed
     */
    public function iShouldBeNotifiedThatMyPasswordHasBeenSuccessfullyChanged(): void
    {
        $this->notificationChecker->checkNotification('has been changed successfully!', NotificationType::success());
    }

    /**
     * @Given I specify the current password as :password
     */
    public function iSpecifyTheCurrentPasswordAs($password): void
    {
        $this->changePasswordPage->specifyCurrentPassword($password);
    }

    /**
     * @Given I specify the new password as :password
     */
    public function iSpecifyTheNewPasswordAs($password): void
    {
        $this->changePasswordPage->specifyNewPassword($password);
    }

    /**
     * @Given I confirm this password as :password
     */
    public function iSpecifyTheConfirmationPasswordAs($password): void
    {
        $this->changePasswordPage->specifyConfirmationPassword($password);
    }

    /**
     * @Then I should be notified that provided password is different than the current one
     */
    public function iShouldBeNotifiedThatProvidedPasswordIsDifferentThanTheCurrentOne(): void
    {
        Assert::true($this->changePasswordPage->checkValidationMessageFor(
            'current_password',
            'Provided password is different than the current one.'
        ));
    }

    /**
     * @Then I should be notified that the entered passwords do not match
     */
    public function iShouldBeNotifiedThatTheEnteredPasswordsDoNotMatch(): void
    {
        Assert::true($this->changePasswordPage->checkValidationMessageFor(
            'new_password',
            'The entered passwords don\'t match'
        ));
    }

    /**
     * @Then I should be notified that the password should be at least 4 characters long
     */
    public function iShouldBeNotifiedThatThePasswordShouldBeAtLeastCharactersLong(): void
    {
        Assert::true($this->changePasswordPage->checkValidationMessageFor(
            'new_password',
            'Password must be at least 4 characters long.'
        ));
    }

    /**
     * @When I subscribe to the newsletter
     */
    public function iSubscribeToTheNewsletter(): void
    {
        $this->profileUpdatePage->subscribeToTheNewsletter();
    }

    /**
     * @Then I should be subscribed to the newsletter
     */
    public function iShouldBeSubscribedToTheNewsletter(): void
    {
        Assert::true($this->profileUpdatePage->isSubscribedToTheNewsletter());
    }

    /**
     * @Then I should be redirected to my account dashboard
     */
    public function iShouldBeRedirectedToMyAccountDashboard(): void
    {
        Assert::true($this->dashboardPage->isOpen(), 'User should be on the account panel dashboard page but they are not.');
    }

    /**
     * @When I want to log in
     */
    public function iWantToLogIn(): void
    {
        $this->loginPage->tryToOpen();
    }
}
