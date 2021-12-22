<?php

declare(strict_types=1);

namespace App\Story;

use App\Factory\AppUserFactory;
use Zenstruck\Foundry\Story;

final class RandomAppUsersStory extends Story
{
    public function build(): void
    {
        AppUserFactory::createMany(10);
    }
}
