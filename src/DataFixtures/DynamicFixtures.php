<?php

namespace App\DataFixtures;

use App\DataFixtures\Factory\ShelterFactory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\DataFixtures\Story\RandomAnimalStory;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class DynamicFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        ShelterFactory::createMany(20);
        RandomAnimalStory::load();
    }

    public static function getGroups(): array
    {
        return ['dynamic'];
    }
}
