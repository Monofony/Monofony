<?php

declare(strict_types=1);

namespace App\Tests\Behat\Page\Backend\Customer;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;

class ShowPage extends SymfonyPage
{
    public function getRouteName(): string
    {
        return 'sylius_backend_customer_show';
    }

    public function getCustomerEmail(): string
    {
        return $this->getElement('customer_email')->getText();
    }

    public function getCustomerPhoneNumber(): string
    {
        return $this->getElement('customer_phone_number')->getText();
    }

    public function getCustomerName(): string
    {
        return $this->getElement('customer_name')->getText();
    }

    public function getRegistrationDate(): \DateTimeInterface
    {
        return new \DateTime(str_replace('Customer since ', '', $this->getElement('registration_date')->getText()));
    }

    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'customer_email' => '#info .content.extra > a',
            'customer_name' => '#info .content > a',
            'customer_phone_number' => '#phone-number',
            'registration_date' => '#info .content .date',
        ]);
    }
}
