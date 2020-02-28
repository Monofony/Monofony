<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context\Ui\Frontend;

use Monofony\Component\Core\Model\Customer\CustomerInterface;
use Behat\Behat\Context\Context;
use App\Tests\Behat\NotificationType;
use App\Tests\Behat\Page\Frontend\Account\DashboardPage;
use App\Tests\Behat\Page\Frontend\Account\LoginPage;
use App\Tests\Behat\Page\Frontend\Account\ProfileUpdatePage;
use App\Tests\Behat\Page\Frontend\Account\RegisterPage;
use App\Tests\Behat\Page\Frontend\Account\VerificationPage;
use App\Tests\Behat\Page\Frontend\HomePage;
use App\Tests\Behat\Service\NotificationCheckerInterface;
use App\Tests\Behat\Service\SharedStorageInterface;
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
    public function iWantToRegisterANewAccount(): void
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
    public function iSpecifyTheEmail($email = null): void
    {
        $this->registerPage->specifyEmail($email);
    }

    /**
     * @When I specify the password as :password
     * @When I do not specify the password
     */
    public function iSpecifyThePasswordAs($password = null): void
    {
        $this->registerPage->specifyPassword($password);
        $this->sharedStorage->set('password', $password);
    }

    /**
     * @When /^I confirm (this password)$/
     */
    public function iConfirmThisPassword($password): void
    {
        $this->registerPage->verifyPassword($password);
    }

    /**
     * @Given I do not confirm the password
     */
    public function iDoNotConfirmPassword(): void
    {
        $this->registerPage->verifyPassword(null);
    }

    /**
     * @When I register this account
     * @When I try to register this account
     */
    public function iRegisterThisAccount(): void
    {
        $this->registerPage->register();
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
     * @Then /^I should be notified that the ([^"]+) is required$/
     */
    public function iShouldBeNotifiedThatElementIsRequired($element): void
    {
        $this->assertFieldValidationMessage($element, sprintf('Please enter your %s.', $element));
    }

    /**
     * @Then I should be notified that the email is already used
     */
    public function iShouldBeNotifiedThatTheEmailIsAlreadyUsed(): void
    {
        $this->assertFieldValidationMessage('email', 'This email is already used.');
    }

    /**
     * @Then I should be notified that the password do not match
     */
    public function iShouldBeNotifiedThatThePasswordDoNotMatch(): void
    {
        $this->assertFieldValidationMessage('password', 'The entered passwords don\'t match');
    }

    /**
     * @Then I should be notified that new account has been successfully created
     * @Then I should be notified that my account has been created and the verification email has been sent
     */
    public function iShouldBeNotifiedThatNewAccountHasBeenSuccessfullyCreated(): void
    {
        $this->notificationChecker->checkNotification(
            'Thank you for registering, check your email to verify your account.',
            NotificationType::success()
        );
    }

    /**
     * @Then I should be logged in
     */
    public function iShouldBeLoggedIn(): void
    {
        Assert::true($this->homePage->hasLogoutButton());
    }

    /**
     * @Then I should not be logged in
     */
    public function iShouldNotBeLoggedIn(): void
    {
        Assert::false($this->homePage->hasLogoutButton());
    }

    /**
     * @Then I should be able to log in as :email with :password password
     */
    public function iShouldBeAbleToLogInAsWithPassword($email, $password): void
    {
        $this->iLogInAsWithPassword($email, $password);
        $this->iShouldBeLoggedIn();
    }

    /**
     * @Then I should not be able to log in as :email with :password password
     */
    public function iShouldNotBeAbleToLogInAsWithPassword($email, $password): void
    {
        $this->iLogInAsWithPassword($email, $password);

        Assert::true($this->loginPage->hasValidationErrorWith('Error Account is disabled.'));
    }

    /**
     * @When I log in as :email with :password password
     */
    public function iLogInAsWithPassword($email, $password): void
    {
        $this->loginPage->open();
        $this->loginPage->specifyUsername($email);
        $this->loginPage->specifyPassword($password);
        $this->loginPage->logIn();
    }

    /**
     * @When I register with email :email and password :password
     */
    public function iRegisterWithEmailAndPassword($email, $password): void
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
    public function myAccountShouldBeVerified(): void
    {
        Assert::true($this->dashboardPage->isVerified());
    }

    /**
     * @When /^(I) try to verify my account using the link from this email$/
     */
    public function iUseItToVerify(UserInterface $user): void
    {
        $this->verificationPage->verifyAccount($user->getEmailVerificationToken());
    }

    /**
     * @When I verify my account using link sent to :customer
     */
    public function iVerifyMyAccount(CustomerInterface $customer): void
    {
        $user = $customer->getUser();
        Assert::notNull($user, 'No account for given customer');

        $this->iUseItToVerify($user);
    }

    /**
     * @When I resend the verification email
     */
    public function iResendVerificationEmail(): void
    {
        $this->dashboardPage->open();
        $this->dashboardPage->pressResendVerificationEmail();
    }

    /**
     * @When I use the verification link from the first email to verify
     */
    public function iUseVerificationLinkFromFirstEmailToVerify(): void
    {
        $token = $this->sharedStorage->get('verification_token');

        $this->verificationPage->verifyAccount($token);
    }

    /**
     * @When I (try to )verify using :token token
     */
    public function iTryToVerifyUsing($token): void
    {
        $this->verificationPage->verifyAccount($token);
    }

    /**
     * @Then /^(?:my|his|her) account should not be verified$/
     */
    public function myAccountShouldNotBeVerified(): void
    {
        $this->dashboardPage->open();

        Assert::false($this->dashboardPage->isVerified());
    }

    /**
     * @Then I should not be able to resend the verification email
     */
    public function iShouldBeUnableToResendVerificationEmail(): void
    {
        $this->dashboardPage->open();

        Assert::false($this->dashboardPage->hasResendVerificationEmailButton());
    }

    /**
     * @Then I should be notified that the verification was successful
     */
    public function iShouldBeNotifiedThatTheVerificationWasSuccessful(): void
    {
        $this->notificationChecker->checkNotification('has been successfully verified.', NotificationType::success());
    }

    /**
     * @Then I should be notified that the verification token is invalid
     */
    public function iShouldBeNotifiedThatTheVerificationTokenIsInvalid(): void
    {
        $this->notificationChecker->checkNotification('The verification token is invalid.', NotificationType::failure());
    }

    /**
     * @Then I should be notified that the verification email has been sent
     */
    public function iShouldBeNotifiedThatTheVerificationEmailHasBeenSent(): void
    {
        $this->notificationChecker->checkNotification(
            'An email with the verification link has been sent to your email address.',
            NotificationType::success()
        );
    }

    /**
     * @When I subscribe to the newsletter
     */
    public function iSubscribeToTheNewsletter(): void
    {
        $this->registerPage->subscribeToTheNewsletter();
    }

    /**
     * @Then I should be subscribed to the newsletter
     */
    public function iShouldBeSubscribedToTheNewsletter(): void
    {
        $this->profileUpdatePage->open();

        Assert::true($this->profileUpdatePage->isSubscribedToTheNewsletter());
    }

    /**
     * @param string $element
     * @param string $expectedMessage
     */
    private function assertFieldValidationMessage($element, $expectedMessage): void
    {
        Assert::true($this->registerPage->checkValidationMessageFor($element, $expectedMessage));
    }
}
