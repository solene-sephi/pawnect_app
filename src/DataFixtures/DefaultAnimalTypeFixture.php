<?php

namespace App\DataFixtures;

use Faker\Factory;
use Faker\Generator;
use App\Entity\AnimalType;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class DefaultAnimalTypeFixture extends Fixture implements FixtureGroupInterface
{
    private Generator $factory;

    private static array $typeNames = ['dog', 'cat', 'rabbit', 'chicken'];

    public function __construct()
    {
        $this->factory = Factory::create();
    }

    public function load(ObjectManager $manager): void
    {
        foreach (self::$typeNames as $key => $name) {
            $type = new AnimalType();
            $type->setName($name);
            $manager->persist($type);
            $this->addReference($name, $type);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['default'];
    }
}