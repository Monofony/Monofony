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

use App\Behat\Page\SymfonyPage;

class VerificationPage extends SymfonyPage
{
    /**
     * {@inheritdoc}
     */
    public function verifyAccount($token)
    {
        $this->tryToOpen(['token' => $token]);
    }

    /**
     * {@inheritdoc}
     */
    public function getRouteName()
    {
        return 'app_frontend_user_verification';
    }
}
