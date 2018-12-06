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

use Behat\Mink\Exception\ElementNotFoundException;
use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;

class ResetPasswordPage extends SymfonyPage
{
    /**
     * {@inheritdoc}
     */
    public function getRouteName(): string
    {
        return 'app_frontend_password_reset';
    }

    public function reset()
    {
        $this->getDocument()->pressButton('Reset');
    }

    /**
     * @param string|null $password
     */
    public function specifyNewPassword(?string $password)
    {
        $this->getElement('password')->setValue($password);
    }

    /**
     * @param string|null $password
     */
    public function specifyConfirmPassword(?string $password)
    {
        $this->getElement('confirm_password')->setValue($password);
    }

    /**
     * @param string $element
     * @param string $message
     *
     * @return bool
     *
     * @throws ElementNotFoundException
     */
    public function checkValidationMessageFor(string $element, string $message): bool
    {
        $errorLabel = $this->getElement($element)->getParent()->getParent()->find('css', '.sylius-validation-error');

        if (null === $errorLabel) {
            throw new ElementNotFoundException($this->getSession(), 'Validation message', 'css', '.sylius-validation-error');
        }

        return $message === $errorLabel->getText();
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'password' => '#sylius_user_reset_password_password_first',
            'confirm_password' => '#sylius_user_reset_password_password_second',
        ]);
    }
}
