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

namespace App\Behat\Context\Ui\Frontend;

use Behat\Behat\Context\Context;
use App\Behat\NotificationType;
use App\Behat\Page\Frontend\Account\ChangePasswordPage;
use App\Behat\Page\Frontend\Account\DashboardPage;
use App\Behat\Page\Frontend\Account\LoginPage;
use App\Behat\Page\Frontend\Account\ProfileUpdatePage;
use App\Behat\Service\NotificationCheckerInterface;
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
    public function iWantToModifyMyProfile()
    {
        $this->profileUpdatePage->open();
    }

    /**
     * @When I specify the first name as :firstName
     * @When I remove the first name
     */
    public function iSpecifyTheFirstName($firstName = null)
    {
        $this->profileUpdatePage->specifyFirstName($firstName);
    }

    /**
     * @When I specify the last name as :lastName
     * @When I remove the last name
     */
    public function iSpecifyTheLastName($lastName = null)
    {
        $this->profileUpdatePage->specifyLastName($lastName);
    }

    /**
     * @When I specify the customer email as :email
     * @When I remove the customer email
     */
    public function iSpecifyCustomerTheEmail($email = null)
    {
        $this->profileUpdatePage->specifyEmail($email);
    }

    /**
     * @When I save my changes
     * @When I try to save my changes
     */
    public function iSaveMyChanges()
    {
        $this->profileUpdatePage->saveChanges();
    }

    /**
     * @Then I should be notified that it has been successfully edited
     */
    public function iShouldBeNotifiedThatItHasBeenSuccessfullyEdited()
    {
        $this->notificationChecker->checkNotification('has been successfully updated.', NotificationType::success());
    }

    /**
     * @Then my name should be :name
     * @Then my name should still be :name
     */
    public function myNameShouldBe($name)
    {
        $this->dashboardPage->open();

        Assert::true($this->dashboardPage->hasCustomerName($name));
    }

    /**
     * @Then my email should be :email
     * @Then my email should still be :email
     */
    public function myEmailShouldBe($email)
    {
        $this->dashboardPage->open();

        Assert::true($this->dashboardPage->hasCustomerEmail($email));
    }

    /**
     * @Then /^I should be notified that the (email|password|city|street|first name|last name) is required$/
     */
    public function iShouldBeNotifiedThatElementIsRequired($element)
    {
        Assert::true($this->profileUpdatePage->checkValidationMessageFor(
            StringInflector::nameToCode($element),
            sprintf('Please enter your %s.', $element)
        ));
    }

    /**
     * @Then /^I should be notified that the (email) is invalid$/
     */
    public function iShouldBeNotifiedThatElementIsInvalid($element)
    {
        Assert::true($this->profileUpdatePage->checkValidationMessageFor(
            StringInflector::nameToCode($element),
            sprintf('This %s is invalid.', $element)
        ));
    }

    /**
     * @Then I should be notified that the email is already used
     */
    public function iShouldBeNotifiedThatTheEmailIsAlreadyUsed()
    {
        Assert::true($this->profileUpdatePage->checkValidationMessageFor('email', 'This email is already used.'));
    }

    /**
     * @Given /^I want to change my password$/
     */
    public function iWantToChangeMyPassword()
    {
        $this->changePasswordPage->open();
    }

    /**
     * @Given I change password from :oldPassword to :newPassword
     */
    public function iChangePasswordTo($oldPassword, $newPassword)
    {
        $this->iSpecifyTheCurrentPasswordAs($oldPassword);
        $this->iSpecifyTheNewPasswordAs($newPassword);
        $this->iSpecifyTheConfirmationPasswordAs($newPassword);
    }

    /**
     * @Then I should be notified that my password has been successfully changed
     */
    public function iShouldBeNotifiedThatMyPasswordHasBeenSuccessfullyChanged()
    {
        $this->notificationChecker->checkNotification('has been changed successfully!', NotificationType::success());
    }

    /**
     * @Given I specify the current password as :password
     */
    public function iSpecifyTheCurrentPasswordAs($password)
    {
        $this->changePasswordPage->specifyCurrentPassword($password);
    }

    /**
     * @Given I specify the new password as :password
     */
    public function iSpecifyTheNewPasswordAs($password)
    {
        $this->changePasswordPage->specifyNewPassword($password);
    }

    /**
     * @Given I confirm this password as :password
     */
    public function iSpecifyTheConfirmationPasswordAs($password)
    {
        $this->changePasswordPage->specifyConfirmationPassword($password);
    }

    /**
     * @Then I should be notified that provided password is different than the current one
     */
    public function iShouldBeNotifiedThatProvidedPasswordIsDifferentThanTheCurrentOne()
    {
        Assert::true($this->changePasswordPage->checkValidationMessageFor(
            'current_password',
            'Provided password is different than the current one.'
        ));
    }

    /**
     * @Then I should be notified that the entered passwords do not match
     */
    public function iShouldBeNotifiedThatTheEnteredPasswordsDoNotMatch()
    {
        Assert::true($this->changePasswordPage->checkValidationMessageFor(
            'new_password',
            'The entered passwords don\'t match'
        ));
    }

    /**
     * @Then I should be notified that the password should be at least 4 characters long
     */
    public function iShouldBeNotifiedThatThePasswordShouldBeAtLeastCharactersLong()
    {
        Assert::true($this->changePasswordPage->checkValidationMessageFor(
            'new_password',
            'Password must be at least 4 characters long.'
        ));
    }

    /**
     * @When I subscribe to the newsletter
     */
    public function iSubscribeToTheNewsletter()
    {
        $this->profileUpdatePage->subscribeToTheNewsletter();
    }

    /**
     * @Then I should be subscribed to the newsletter
     */
    public function iShouldBeSubscribedToTheNewsletter()
    {
        Assert::true($this->profileUpdatePage->isSubscribedToTheNewsletter());
    }

    /**
     * @Then I should be redirected to my account dashboard
     */
    public function iShouldBeRedirectedToMyAccountDashboard()
    {
        Assert::true($this->dashboardPage->isOpen(), 'User should be on the account panel dashboard page but they are not.');
    }

    /**
     * @When I want to log in
     */
    public function iWantToLogIn()
    {
        $this->loginPage->tryToOpen();
    }
}
