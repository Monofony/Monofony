<?php

/*
 * This file is part of AppName.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Tests\Behat\Page\Backend\Administrator;

use App\Tests\Behat\Page\Backend\Crud\UpdatePageInterface;
use App\Tests\Behat\Page\Backend\Crud\UpdatePage as BaseUpdatePage;

class UpdatePage extends BaseUpdatePage implements UpdatePageInterface
{
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
            'email' => '#sylius_admin_user_email',
            'enabled' => '#sylius_admin_user_enabled',
            'locale_code' => '#sylius_admin_user_localeCode',
            'password' => '#sylius_admin_user_plainPassword',
            'username' => '#sylius_admin_user_username',
        ]);
    }
}
