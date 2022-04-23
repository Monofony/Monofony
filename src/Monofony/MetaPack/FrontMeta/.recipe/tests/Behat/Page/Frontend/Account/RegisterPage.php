<?php

declare(strict_types=1);

namespace App\Tests\Behat\Page\Frontend\Account;

use Behat\Mink\Exception\ElementNotFoundException;
use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;
use Monofony\Component\Core\Formatter\StringInflector;

class RegisterPage extends SymfonyPage
{
    public function getRouteName(): string
    {
        return 'app_frontend_register';
    }

    public function checkValidationMessageFor(string $element, string $message): bool
    {
        $errorLabel = $this
            ->getElement(StringInflector::nameToCode($element))
            ->getParent()
            ->find('css', '.sylius-validation-error')
        ;

        if (null === $errorLabel) {
            throw new ElementNotFoundException($this->getSession(), 'Validation message', 'css', '.sylius-validation-error');
        }

        return $message === $errorLabel->getText();
    }

    public function register(): void
    {
        $this->getDocument()->pressButton('Create an account');
    }

    public function specifyEmail(?string $email): void
    {
        $this->getDocument()->fillField('Email', $email);
    }

    public function specifyPassword(?string $password): void
    {
        $this->getDocument()->fillField('Password', $password);
    }

    public function specifyFirstName(?string $firstName): void
    {
        $this->getDocument()->fillField('First name', $firstName);
    }

    public function specifyLastName(?string $lastName): void
    {
        $this->getDocument()->fillField('Last name', $lastName);
    }

    public function verifyPassword(?string $password): void
    {
        $this->getDocument()->fillField('Verification', $password);
    }

    public function subscribeToTheNewsletter(): void
    {
        $this->getDocument()->checkField('Subscribe to the newsletter');
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'email' => '#sylius_customer_registration_email',
            'password_verification' => '#sylius_customer_registration_user_plainPassword_second',
            'password' => '#sylius_customer_registration_user_plainPassword_first',
        ]);
    }
}
