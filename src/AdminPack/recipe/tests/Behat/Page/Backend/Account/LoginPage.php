<?php

declare(strict_types=1);

namespace App\Tests\Behat\Page\Backend\Account;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;

class LoginPage extends SymfonyPage
{
    public function hasValidationErrorWith(string $message): bool
    {
        return $this->getElement('validation_error')->getText() === $message;
    }

    public function logIn(): void
    {
        $this->getDocument()->pressButton('Login');
    }

    public function specifyPassword(string $password): void
    {
        $this->getDocument()->fillField('Password', $password);
    }

    public function specifyUsername(string $username): void
    {
        $this->getDocument()->fillField('Username', $username);
    }

    public function getRouteName(): string
    {
        return 'sylius_backend_login';
    }

    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'validation_error' => '.message.negative',
        ]);
    }
}
