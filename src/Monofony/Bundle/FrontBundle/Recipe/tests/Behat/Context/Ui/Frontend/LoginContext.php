<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context\Ui\Frontend;

use App\Tests\Behat\Page\Frontend\Account\ResetPasswordPage;
use Monofony\Bundle\CoreBundle\Tests\Behat\Service\Resolver\CurrentPageResolverInterface;
use Behat\Behat\Context\Context;
use App\Tests\Behat\NotificationType;
use App\Tests\Behat\Page\Frontend\Account\LoginPage;
use App\Tests\Behat\Page\Frontend\Account\RegisterPage;
use App\Tests\Behat\Page\Frontend\Account\RequestPasswordResetPage;
use App\Tests\Behat\Page\Frontend\HomePage;
use Monofony\Bundle\CoreBundle\Tests\Behat\Service\NotificationCheckerInterface;
use Sylius\Component\User\Model\UserInterface;
use Webmozart\Assert\Assert;

final class LoginContext implements Context
{
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
     * @var RequestPasswordResetPage
     */
    private $requestPasswordResetPage;

    /**
     * @var ResetPasswordPage
     */
    private $resetPasswordPage;

    /**
     * @var NotificationCheckerInterface
     */
    private $notificationChecker;

    /**
     * @var CurrentPageResolverInterface
     */
    private $currentPageResolver;

    /**
     * @param HomePage                     $homePage
     * @param LoginPage                    $loginPage
     * @param RegisterPage                 $registerPage
     * @param RequestPasswordResetPage     $requestPasswordResetPage
     * @param ResetPasswordPage            $resetPasswordPage
     * @param NotificationCheckerInterface $notificationChecker
     * @param CurrentPageResolverInterface $currentPageResolver
     */
    public function __construct(
        HomePage $homePage,
        LoginPage $loginPage,
        RegisterPage $registerPage,
        RequestPasswordResetPage $requestPasswordResetPage,
        ResetPasswordPage $resetPasswordPage,
        NotificationCheckerInterface $notificationChecker,
        CurrentPageResolverInterface $currentPageResolver
    ) {
        $this->homePage = $homePage;
        $this->loginPage = $loginPage;
        $this->registerPage = $registerPage;
        $this->requestPasswordResetPage = $requestPasswordResetPage;
        $this->resetPasswordPage = $resetPasswordPage;
        $this->notificationChecker = $notificationChecker;
        $this->currentPageResolver = $currentPageResolver;
    }

    /**
     * @When I want to log in
     */
    public function iWantToLogIn(): void
    {
        $this->loginPage->open();
    }

    /**
     * @When I want to reset password
     */
    public function iWantToResetPassword(): void
    {
        $this->requestPasswordResetPage->open();
    }

    /**
     * @When /^I follow link on my email to reset (my) password$/
     */
    public function iFollowLinkOnMyEmailToResetPassword(UserInterface $user): void
    {
        $this->resetPasswordPage->open(['token' => $user->getPasswordResetToken()]);
    }

    /**
     * @When I specify the username as :username
     */
    public function iSpecifyTheUsername($username = null): void
    {
        $this->loginPage->specifyUsername($username);
    }

    /**
     * @When I specify the email as :email
     * @When I do not specify the email
     */
    public function iSpecifyTheEmail($email = null): void
    {
        $this->requestPasswordResetPage->specifyEmail($email);
    }

    /**
     * @When I specify the password as :password
     * @When I do not specify the password
     */
    public function iSpecifyThePasswordAs($password = null): void
    {
        $this->loginPage->specifyPassword($password);
    }

    /**
     * @When I specify my new password as :password
     * @When I do not specify my new password
     */
    public function iSpecifyMyNewPassword(string $password = null): void
    {
        $this->resetPasswordPage->specifyNewPassword($password);
    }

    /**
     * @When I confirm my new password as :password
     * @When I do not confirm my new password
     */
    public function iConfirmMyNewPassword(string $password = null): void
    {
        $this->resetPasswordPage->specifyConfirmPassword($password);
    }

    /**
     * @When I log in
     * @When I try to log in
     */
    public function iLogIn(): void
    {
        $this->loginPage->logIn();
    }

    /**
     * @When I reset it
     * @When I try to reset it
     */
    public function iResetIt(): void
    {
        /** @var RequestPasswordResetPage|ResetPasswordPage $currentPage */
        $currentPage = $this->currentPageResolver->getCurrentPageWithForm([$this->requestPasswordResetPage, $this->resetPasswordPage]);

        $currentPage->reset();
    }

    /**
     * @When I sign in with email :email and password :password
     */
    public function iSignInWithEmailAndPassword(string $email, string $password): void
    {
        $this->iWantToLogIn();
        $this->iSpecifyTheUsername($email);
        $this->iSpecifyThePasswordAs($password);
        $this->iLogIn();
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
     * @Then I should be logged in
     */
    public function iShouldBeLoggedIn(): void
    {
        $this->homePage->verify();
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
     * @Then I should be notified about bad credentials
     */
    public function iShouldBeNotifiedAboutBadCredentials(): void
    {
        Assert::true($this->loginPage->hasValidationErrorWith('Error Invalid credentials.'));
    }

    /**
     * @Then I should be notified about disabled account
     */
    public function iShouldBeNotifiedAboutDisabledAccount(): void
    {
        Assert::true($this->loginPage->hasValidationErrorWith('Error Account is disabled.'));
    }

    /**
     * @Then I should be notified that email with reset instruction has been sent
     */
    public function iShouldBeNotifiedThatEmailWithResetInstructionWasSent(): void
    {
        $this->notificationChecker->checkNotification('If the email you have specified exists in our system, we have sent there an instruction on how to reset your password.', NotificationType::success());
    }

    /**
     * @Then I should be notified that the :elementName is required
     */
    public function iShouldBeNotifiedThatElementIsRequired($elementName): void
    {
        Assert::true($this->requestPasswordResetPage->checkValidationMessageFor($elementName, sprintf('Please enter your %s.', $elementName)));
    }

    /**
     * @Then I should be able to log in as :email with :password password
     * @Then the customer should be able to log in as :email with :password password
     */
    public function iShouldBeAbleToLogInAsWithPassword($email, $password): void
    {
        $this->loginPage->open();
        $this->loginPage->specifyUsername($email);
        $this->loginPage->specifyPassword($password);
        $this->loginPage->logIn();

        $this->iShouldBeLoggedIn();
    }

    /**
     * @Then I should be notified that my password has been successfully reset
     */
    public function iShouldBeNotifiedThatMyPasswordHasBeenSuccessfullyReset(): void
    {
        $this->notificationChecker->checkNotification('has been reset successfully!', NotificationType::success());
    }

    /**
     * @Then I should be notified that the entered passwords do not match
     */
    public function iShouldBeNotifiedThatTheEnteredPasswordsDoNotMatch(): void
    {
        Assert::true($this->resetPasswordPage->checkValidationMessageFor(
            'password',
            'The entered passwords don\'t match'
        ));
    }

    /**
     * @Then I should be notified that the password should be at least 4 characters long
     */
    public function iShouldBeNotifiedThatThePasswordShouldBeAtLeastCharactersLong(): void
    {
        Assert::true($this->resetPasswordPage->checkValidationMessageFor(
            'password',
            'Password must be at least 4 characters long.'
        ));
    }
}
