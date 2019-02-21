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
use App\Behat\Page\Frontend\Account\DashboardPage;
use App\Behat\Page\Frontend\Account\LoginPage;
use App\Behat\Page\Frontend\Account\ProfileUpdatePage;
use App\Behat\Page\Frontend\Account\RegisterPage;
use App\Behat\Page\Frontend\Account\VerificationPage;
use App\Behat\Page\Frontend\HomePage;
use App\Behat\Service\NotificationCheckerInterface;
use App\Behat\Service\SharedStorageInterface;
use Sylius\Component\Customer\Model\CustomerInterface;
use Sylius\Component\User\Model\UserInterface;
use Webmozart\Assert\Assert;

class RegistrationContext implements Context
{
    /**
     * @var SharedStorageInterface
     */
    private $sharedStorage;

    /**
     * @var DashboardPage
     */
    private $dashboardPage;

    /**
     * @var HomePage
     */
    private $homePage;

    /**
     * @var LoginPage
     */
    private $loginPage;

    /**
     * @var RegisterPage
     */
    private $registerPage;

    /**
     * @var VerificationPage
     */
    private $verificationPage;

    /**
     * @var ProfileUpdatePage
     */
    private $profileUpdatePage;

    /**
     * @var NotificationCheckerInterface
     */
    private $notificationChecker;

    /**
     * @param SharedStorageInterface       $sharedStorage
     * @param DashboardPage                $dashboardPage
     * @param HomePage                     $homePage
     * @param LoginPage                    $loginPage
     * @param RegisterPage                 $registerPage
     * @param VerificationPage             $verificationPage
     * @param ProfileUpdatePage            $profileUpdatePage
     * @param NotificationCheckerInterface $notificationChecker
     */
    public function __construct(
        SharedStorageInterface $sharedStorage,
        DashboardPage $dashboardPage,
        HomePage $homePage,
        LoginPage $loginPage,
        RegisterPage $registerPage,
        VerificationPage $verificationPage,
        ProfileUpdatePage $profileUpdatePage,
        NotificationCheckerInterface $notificationChecker
    ) {
        $this->sharedStorage = $sharedStorage;
        $this->dashboardPage = $dashboardPage;
        $this->homePage = $homePage;
        $this->loginPage = $loginPage;
        $this->registerPage = $registerPage;
        $this->verificationPage = $verificationPage;
        $this->profileUpdatePage = $profileUpdatePage;
        $this->notificationChecker = $notificationChecker;
    }

    /**
     * @When /^I want to(?:| again) register a new account$/
     */
    public function iWantToRegisterANewAccount()
    {
        $this->registerPage->open();
    }

    /**
     * @When I specify the first name as :firstName
     * @When I do not specify the first name
     */
    public function iSpecifyTheFirstName(?string $firstName = null): void
    {
        $this->registerPage->specifyFirstName($firstName);
    }

    /**
     * @When I specify the last name as :lastName
     * @When I do not specify the last name
     */
    public function iSpecifyTheLastName(?string $lastName = null): void
    {
        $this->registerPage->specifyLastName($lastName);
    }


    /**
     * @When I specify the email as :email
     * @When I do not specify the email
     */
    public function iSpecifyTheEmail($email = null)
    {
        $this->registerPage->specifyEmail($email);
    }

    /**
     * @When I specify the password as :password
     * @When I do not specify the password
     */
    public function iSpecifyThePasswordAs($password = null)
    {
        $this->registerPage->specifyPassword($password);
        $this->sharedStorage->set('password', $password);
    }

    /**
     * @When /^I confirm (this password)$/
     */
    public function iConfirmThisPassword($password)
    {
        $this->registerPage->verifyPassword($password);
    }

    /**
     * @Given I do not confirm the password
     */
    public function iDoNotConfirmPassword()
    {
        $this->registerPage->verifyPassword(null);
    }

    /**
     * @When I specify the phone number as :phoneNumber
     */
    public function iSpecifyThePhoneNumberAs($phoneNumber)
    {
        $this->registerPage->specifyPhoneNumber($phoneNumber);
    }

    /**
     * @When I register this account
     * @When I try to register this account
     */
    public function iRegisterThisAccount()
    {
        $this->registerPage->register();
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
     * @Then /^I should be notified that the ([^"]+) is required$/
     */
    public function iShouldBeNotifiedThatElementIsRequired($element)
    {
        $this->assertFieldValidationMessage($element, sprintf('Please enter your %s.', $element));
    }

    /**
     * @Then I should be notified that the email is already used
     */
    public function iShouldBeNotifiedThatTheEmailIsAlreadyUsed()
    {
        $this->assertFieldValidationMessage('email', 'This email is already used.');
    }

    /**
     * @Then I should be notified that the password do not match
     */
    public function iShouldBeNotifiedThatThePasswordDoNotMatch()
    {
        $this->assertFieldValidationMessage('password', 'The entered passwords don\'t match');
    }

    /**
     * @Then I should be notified that new account has been successfully created
     * @Then I should be notified that my account has been created and the verification email has been sent
     */
    public function iShouldBeNotifiedThatNewAccountHasBeenSuccessfullyCreated()
    {
        $this->notificationChecker->checkNotification(
            'Thank you for registering, check your email to verify your account.',
            NotificationType::success()
        );
    }

    /**
     * @Then I should be logged in
     */
    public function iShouldBeLoggedIn()
    {
        Assert::true($this->homePage->hasLogoutButton());
    }

    /**
     * @Then I should not be logged in
     */
    public function iShouldNotBeLoggedIn()
    {
        Assert::false($this->homePage->hasLogoutButton());
    }

    /**
     * @Then I should be able to log in as :email with :password password
     */
    public function iShouldBeAbleToLogInAsWithPassword($email, $password)
    {
        $this->iLogInAsWithPassword($email, $password);
        $this->iShouldBeLoggedIn();
    }

    /**
     * @Then I should not be able to log in as :email with :password password
     */
    public function iShouldNotBeAbleToLogInAsWithPassword($email, $password)
    {
        $this->iLogInAsWithPassword($email, $password);

        Assert::true($this->loginPage->hasValidationErrorWith('Error Account is disabled.'));
    }

    /**
     * @When I log in as :email with :password password
     */
    public function iLogInAsWithPassword($email, $password)
    {
        $this->loginPage->open();
        $this->loginPage->specifyUsername($email);
        $this->loginPage->specifyPassword($password);
        $this->loginPage->logIn();
    }

    /**
     * @When I register with email :email and password :password
     */
    public function iRegisterWithEmailAndPassword($email, $password)
    {
        $this->registerPage->open();
        $this->registerPage->specifyEmail($email);
        $this->registerPage->specifyPassword($password);
        $this->registerPage->verifyPassword($password);
        $this->registerPage->specifyFirstName('Carrot');
        $this->registerPage->specifyLastName('Ironfoundersson');
        $this->registerPage->register();
    }

    /**
     * @Then /^my account should be verified$/
     */
    public function myAccountShouldBeVerified()
    {
        Assert::true($this->dashboardPage->isVerified());
    }

    /**
     * @When /^(I) try to verify my account using the link from this email$/
     */
    public function iUseItToVerify(UserInterface $user)
    {
        $this->verificationPage->verifyAccount($user->getEmailVerificationToken());
    }

    /**
     * @When I verify my account using link sent to :customer
     */
    public function iVerifyMyAccount(CustomerInterface $customer)
    {
        $user = $customer->getUser();
        Assert::notNull($user, 'No account for given customer');

        $this->iUseItToVerify($user);
    }

    /**
     * @When I resend the verification email
     */
    public function iResendVerificationEmail()
    {
        $this->dashboardPage->open();
        $this->dashboardPage->pressResendVerificationEmail();
    }

    /**
     * @When I use the verification link from the first email to verify
     */
    public function iUseVerificationLinkFromFirstEmailToVerify()
    {
        $token = $this->sharedStorage->get('verification_token');

        $this->verificationPage->verifyAccount($token);
    }

    /**
     * @When I (try to )verify using :token token
     */
    public function iTryToVerifyUsing($token)
    {
        $this->verificationPage->verifyAccount($token);
    }

    /**
     * @Then /^(?:my|his|her) account should not be verified$/
     */
    public function myAccountShouldNotBeVerified()
    {
        $this->dashboardPage->open();

        Assert::false($this->dashboardPage->isVerified());
    }

    /**
     * @Then I should not be able to resend the verification email
     */
    public function iShouldBeUnableToResendVerificationEmail()
    {
        $this->dashboardPage->open();

        Assert::false($this->dashboardPage->hasResendVerificationEmailButton());
    }

    /**
     * @Then I should be notified that the verification was successful
     */
    public function iShouldBeNotifiedThatTheVerificationWasSuccessful()
    {
        $this->notificationChecker->checkNotification('has been successfully verified.', NotificationType::success());
    }

    /**
     * @Then I should be notified that the verification token is invalid
     */
    public function iShouldBeNotifiedThatTheVerificationTokenIsInvalid()
    {
        $this->notificationChecker->checkNotification('The verification token is invalid.', NotificationType::failure());
    }

    /**
     * @Then I should be notified that the verification email has been sent
     */
    public function iShouldBeNotifiedThatTheVerificationEmailHasBeenSent()
    {
        $this->notificationChecker->checkNotification(
            'An email with the verification link has been sent to your email address.',
            NotificationType::success()
        );
    }

    /**
     * @When I subscribe to the newsletter
     */
    public function iSubscribeToTheNewsletter()
    {
        $this->registerPage->subscribeToTheNewsletter();
    }

    /**
     * @Then I should be subscribed to the newsletter
     */
    public function iShouldBeSubscribedToTheNewsletter()
    {
        $this->profileUpdatePage->open();

        Assert::true($this->profileUpdatePage->isSubscribedToTheNewsletter());
    }

    /**
     * @param string $element
     * @param string $expectedMessage
     */
    private function assertFieldValidationMessage($element, $expectedMessage)
    {
        Assert::true($this->registerPage->checkValidationMessageFor($element, $expectedMessage));
    }
}
