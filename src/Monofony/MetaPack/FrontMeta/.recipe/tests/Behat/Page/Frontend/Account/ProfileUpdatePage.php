<?php

declare(strict_types=1);

namespace App\Tests\Behat\Page\Frontend\Account;

use Behat\Mink\Exception\ElementNotFoundException;
use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;

class ProfileUpdatePage extends SymfonyPage
{
    public function getRouteName(): string
    {
        return 'sylius_frontend_account_profile_update';
    }

    public function checkValidationMessageFor(string $element, string $message): bool
    {
        $errorLabel = $this->getElement($element)->getParent()->find('css', '.sylius-validation-error');

        if (null === $errorLabel) {
            throw new ElementNotFoundException($this->getSession(), 'Validation message', 'css', '.sylius-validation-error');
        }

        return $message === $errorLabel->getText();
    }

    public function specifyFirstName(?string $firstName): void
    {
        $this->getDocument()->fillField('First name', $firstName);
    }

    public function specifyLastName(?string $lastName): void
    {
        $this->getDocument()->fillField('Last name', $lastName);
    }

    public function specifyEmail(?string $email): void
    {
        $this->getDocument()->fillField('Email', $email);
    }

    public function saveChanges(): void
    {
        $this->getDocument()->pressButton('Save changes');
    }

    public function subscribeToTheNewsletter(): void
    {
        $this->getDocument()->checkField('Subscribe to the newsletter');
    }

    public function isSubscribedToTheNewsletter(): bool
    {
        return $this->getDocument()->hasCheckedField('Subscribe to the newsletter');
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'email' => '#sylius_customer_profile_email',
            'first_name' => '#sylius_customer_profile_firstName',
            'last_name' => '#sylius_customer_profile_lastName',
        ]);
    }
}
