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

namespace App\Behat\Page\Frontend\Account;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;

class LoginPage extends SymfonyPage
{
    /**
     * {@inheritdoc}
     */
    public function hasValidationErrorWith($message)
    {
        return $this->getElement('validation_error')->getText() === $message;
    }

    public function logIn()
    {
        $this->getDocument()->pressButton('Login');
    }

    /**
     * @param string|null $password
     *
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function specifyPassword(?string $password)
    {
        $this->getElement('password')->setValue($password);
    }

    /**
     * @param string $username
     *
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function specifyUsername(string $username)
    {
        $this->getElement('username')->setValue($username);
    }

    /**
     * {@inheritdoc}
     */
    public function getRouteName(): string
    {
        return 'app_frontend_login';
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'username' => '#_username',
            'password' => '#_password',
            'validation_error' => '.message.negative',
        ]);
    }
}
