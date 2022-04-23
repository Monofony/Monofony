<?php

declare(strict_types=1);

namespace App\Tests\Behat\Page\Frontend\Account;

use Behat\Mink\Exception\ElementNotFoundException;
use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;

class RequestPasswordResetPage extends SymfonyPage
{
    public function checkValidationMessageFor(string $element, string $message): bool
    {
        $errorLabel = $this->getElement($element)->getParent()->getParent()->find('css', '.sylius-validation-error');

        if (null === $errorLabel) {
            throw new ElementNotFoundException($this->getSession(), 'Validation message', 'css', '.sylius-validation-error');
        }

        return $message === $errorLabel->getText();
    }

    public function reset(): void
    {
        $this->getDocument()->pressButton('Reset');
    }

    public function specifyEmail(?string $email): void
    {
        $this->getDocument()->fillField('Email', $email);
    }

    public function getRouteName(): string
    {
        return 'sylius_user_request_password_reset_token';
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'email' => '#sylius_user_request_password_reset_email',
        ]);
    }
}
