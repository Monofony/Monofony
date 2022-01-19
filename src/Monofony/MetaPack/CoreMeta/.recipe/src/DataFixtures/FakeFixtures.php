<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Story\RandomAppUsersStory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class FakeFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        RandomAppUsersStory::load();
    }

    public static function getGroups(): array
    {
        return ['fake'];
    }
}
