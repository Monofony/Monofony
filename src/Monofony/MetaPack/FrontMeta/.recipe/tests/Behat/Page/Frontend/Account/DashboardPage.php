<?php

declare(strict_types=1);

namespace App\Tests\Behat\Page\Frontend\Account;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;

class DashboardPage extends SymfonyPage
{
    public function getRouteName(): string
    {
        return 'sylius_frontend_account_dashboard';
    }

    public function hasCustomerName(string $name): bool
    {
        return $this->hasValueInCustomerSection($name);
    }

    public function hasCustomerEmail(string $email): bool
    {
        return $this->hasValueInCustomerSection($email);
    }

    public function isVerified(): bool
    {
        return !$this->hasElement('verification');
    }

    public function hasResendVerificationEmailButton(): bool
    {
        return $this->getDocument()->hasButton('Verify');
    }

    public function pressResendVerificationEmail(): void
    {
        $this->getDocument()->pressButton('Verify');
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'customer' => '#customer-information',
            'verification' => '#verification-form',
        ]);
    }

    private function hasValueInCustomerSection(string $value): bool
    {
        $customerText = $this->getElement('customer')->getText();

        return false !== stripos($customerText, $value);
    }
}
