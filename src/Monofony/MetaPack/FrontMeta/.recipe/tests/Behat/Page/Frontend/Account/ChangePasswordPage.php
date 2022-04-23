<?php

declare(strict_types=1);

namespace App\Tests\Behat\Page\Frontend\Account;

use Behat\Mink\Exception\ElementNotFoundException;
use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;

class ChangePasswordPage extends SymfonyPage
{
    public function getRouteName(): string
    {
        return 'sylius_frontend_account_change_password';
    }

    public function checkValidationMessageFor(string $element, string $message): bool
    {
        $errorLabel = $this->getElement($element)->getParent()->find('css', '.sylius-validation-error');

        if (null === $errorLabel) {
            throw new ElementNotFoundException($this->getSession(), 'Validation message', 'css', '.sylius-validation-error');
        }

        return $message === $errorLabel->getText();
    }

    public function specifyCurrentPassword(?string $password): void
    {
        $this->getElement('current_password')->setValue($password);
    }

    public function specifyNewPassword(?string $password): void
    {
        $this->getElement('new_password')->setValue($password);
    }

    public function specifyConfirmationPassword(?string $password): void
    {
        $this->getElement('confirmation')->setValue($password);
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'confirmation' => '#sylius_user_change_password_newPassword_second',
            'current_password' => '#sylius_user_change_password_currentPassword',
            'new_password' => '#sylius_user_change_password_newPassword_first',
        ]);
    }
}
