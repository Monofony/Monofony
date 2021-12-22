<?php

declare(strict_types=1);

namespace App\Story;

use App\Factory\AdminUserFactory;
use Zenstruck\Foundry\Story;

final class DefaultAdministratorsStory extends Story
{
    public function build(): void
    {
        AdminUserFactory::createOne([
            'email' => 'admin@example.com',
            'password' => 'admin',
        ]);
    }
}
