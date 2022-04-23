<?php

declare(strict_types=1);

namespace App\Tests\Behat\Page\Frontend\Account;

use Behat\Mink\Exception\ElementNotFoundException;
use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;

class ResetPasswordPage extends SymfonyPage
{
    public function getRouteName(): string
    {
        return 'app_frontend_password_reset';
    }

    public function reset(): void
    {
        $this->getDocument()->pressButton('Reset');
    }

    public function specifyNewPassword(?string $password): void
    {
        $this->getElement('password')->setValue($password);
    }

    public function specifyConfirmPassword(?string $password): void
    {
        $this->getElement('confirm_password')->setValue($password);
    }

    public function checkValidationMessageFor(string $element, string $message): bool
    {
        $errorLabel = $this->getElement($element)->getParent()->find('css', '.sylius-validation-error');

        if (null === $errorLabel) {
            throw new ElementNotFoundException($this->getSession(), 'Validation message', 'css', '.sylius-validation-error');
        }

        return $message === $errorLabel->getText();
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'password' => '#sylius_user_reset_password_password_first',
            'confirm_password' => '#sylius_user_reset_password_password_second',
        ]);
    }
}
