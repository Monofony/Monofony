<?php

declare(strict_types=1);

namespace App\Tests\Behat\Page\Backend\Administrator;

use Monofony\Bridge\Behat\Crud\AbstractUpdatePage;
use Monofony\Bridge\Behat\Crud\UpdatePageInterface;

class UpdatePage extends AbstractUpdatePage implements UpdatePageInterface
{
    /**
     * {@inheritdoc}
     */
    public function getRouteName(): string
    {
        return 'sylius_backend_admin_user_update';
    }

    public function attachAvatar(string $path): void
    {
        $filesPath = $this->getParameter('files_path');

        $imageForm = $this->getElement('avatar')->find('css', 'input[type="file"]');

        $imageForm->attachFile($filesPath.$path);
    }

    public function changeUsername(?string $username): void
    {
        $this->getElement('username')->setValue($username);
    }

    /**
     * {@inheritdoc}
     */
    public function changeEmail(?string $email): void
    {
        $this->getElement('email')->setValue($email);
    }

    /**
     * {@inheritdoc}
     */
    public function changePassword(?string $password): void
    {
        $this->getElement('password')->setValue($password);
    }

    /**
     * {@inheritdoc}
     */
    public function changeLocale(?string $localeCode): void
    {
        $this->getElement('locale_code')->selectOption($localeCode);
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'avatar' => '#sylius_admin_user_avatar',
            'email' => '#sylius_admin_user_email',
            'enabled' => '#sylius_admin_user_enabled',
            'locale_code' => '#sylius_admin_user_localeCode',
            'password' => '#sylius_admin_user_plainPassword',
            'username' => '#sylius_admin_user_username',
        ]);
    }
}
