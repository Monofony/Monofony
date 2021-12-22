<?php

declare(strict_types=1);

namespace App\Story;

use App\Factory\AppUserFactory;
use Zenstruck\Foundry\Story;

final class DefaultAppUsersStory extends Story
{
    public function build(): void
    {
        AppUserFactory::createOne([
            'email' => 'customer@example.com',
            'password' => 'password',
        ]);
    }
}
