<?php

namespace App\DataFixtures;

use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\DataFixtures\Story\DefaultAnimalTypeStory;
use App\DataFixtures\Story\DefaultAnimalBreedStory;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class DefaultFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        DefaultAnimalTypeStory::load();
        DefaultAnimalBreedStory::load();
    }

    public static function getGroups(): array
    {
        return ['default'];
    }

}