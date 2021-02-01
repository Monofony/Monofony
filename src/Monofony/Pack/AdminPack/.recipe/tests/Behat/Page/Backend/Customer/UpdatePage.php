<?php

declare(strict_types=1);

namespace App\Tests\Behat\Page\Backend\Customer;

use Behat\Mink\Element\NodeElement;
use Monofony\Bridge\Behat\Behaviour\Toggles;
use Monofony\Bridge\Behat\Crud\AbstractUpdatePage;
use Monofony\Bridge\Behat\Crud\UpdatePageInterface;

class UpdatePage extends AbstractUpdatePage implements UpdatePageInterface
{
    use Toggles;

    /**
     * {@inheritdoc}
     */
    public function getRouteName(): string
    {
        return 'sylius_backend_customer_update';
    }

    public function getFullName(): string
    {
        $firstNameElement = $this->getElement('first_name')->getValue();
        $lastNameElement = $this->getElement('last_name')->getValue();

        return sprintf('%s %s', $firstNameElement, $lastNameElement);
    }

    public function changeFirstName(?string $firstName): void
    {
        $this->getDocument()->fillField('First name', $firstName);
    }

    public function getFirstName(): ?string
    {
        return $this->getElement('first_name')->getValue();
    }

    public function changeLastName(?string $lastName): void
    {
        $this->getDocument()->fillField('Last name', $lastName);
    }

    public function getLastName(): ?string
    {
        return $this->getElement('last_name')->getValue();
    }

    public function changeEmail(?string $email): void
    {
        $this->getDocument()->fillField('Email', $email);
    }

    public function changePassword(?string $password): void
    {
        $this->getDocument()->fillField('Password', $password);
    }

    public function getPassword(): NodeElement
    {
        return $this->getElement('password');
    }

    public function subscribeToTheNewsletter(): void
    {
        $this->getDocument()->checkField('Subscribe to the newsletter');
    }

    public function isSubscribedToTheNewsletter(): bool
    {
        return $this->getDocument()->hasCheckedField('Subscribe to the newsletter');
    }

    public function getGroupName(): string
    {
        return $this->getElement('group')->getText();
    }

    /**
     * {@inheritdoc}
     */
    protected function getToggleableElement(): NodeElement
    {
        return $this->getElement('enabled');
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'email' => '#sylius_customer_email',
            'enabled' => '#sylius_customer_user_enabled',
            'first_name' => '#sylius_customer_firstName',
            'group' => '#sylius_customer_group',
            'last_name' => '#sylius_customer_lastName',
            'password' => '#sylius_customer_user_password',
        ]);
    }
}
