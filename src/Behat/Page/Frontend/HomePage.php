<?php

/*
 * This file is part of AppName.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Behat\Page\Frontend;

use App\Behat\Page\SymfonyPage;

class HomePage extends SymfonyPage
{
    /**
     * {@inheritdoc}
     */
    public function getRouteName()
    {
        return 'app_frontend_homepage';
    }

    /**
     * @throws \Behat\Mink\Exception\ElementNotFoundException
     */
    public function logOut(): void
    {
        $this->getElement('logout_button')->click();
    }

    /**
     * @return bool
     */
    public function hasLogoutButton(): bool
    {
        return $this->hasElement('logout_button');
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefinedElements()
    {
        return array_merge(parent::getDefinedElements(), [
            'logout_button' => '.app-logout-button',
        ]);
    }
}
