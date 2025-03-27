<?php

namespace App\DataFixtures;

use Faker\Factory;
use Faker\Generator;
use App\Entity\AnimalType;
use App\Entity\AnimalBreed;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class DefaultAnimalBreedFixture extends Fixture implements FixtureGroupInterface, DependentFixtureInterface
{
    private Generator $factory;

    private static array $breedsByType = [
        'cat' => [
            'abyssinian',
            'bengal',
            'birman',
            'persian',
            'siamese',
            'sphynx'
        ],
        'dog' => [
            'beagle',
            'chihuahua',
            'golden_retriever',
            'labrador',
            'pug',
            'samoyed'
        ],
    ];

    public function __construct()
    {
        $this->factory = Factory::create();
    }

    public function load(ObjectManager $manager): void
    {

        foreach (self::$breedsByType as $typeName => $breeds) {

            $type = $this->getReference($typeName, AnimalType::class);

            foreach ($breeds as $key => $breedName) {
                $breed = new AnimalBreed();
                $breed->setName($breedName)
                    ->setType($type);
                $manager->persist($breed);
            }
            $manager->flush();
        }
    }

    public function getDependencies(): array
    {
        return [
            DefaultAnimalTypeFixture::class,
        ];
    }

    public static function getGroups(): array
    {
        return ['default'];
    }
}