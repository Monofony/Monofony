<?php

declare(strict_types=1);

namespace App\Tests\Behat\Page\Frontend\Account;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;

class VerificationPage extends SymfonyPage
{
    public function verifyAccount(string $token): void
    {
        $this->tryToOpen(['token' => $token]);
    }

    public function getRouteName(): string
    {
        return 'sylius_frontend_user_verification';
    }
}
