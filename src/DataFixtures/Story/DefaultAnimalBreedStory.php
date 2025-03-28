<?php

namespace App\DataFixtures\Story;

use Zenstruck\Foundry\Story;
use App\DataFixtures\Factory\AnimalTypeFactory;
use App\DataFixtures\Factory\AnimalBreedFactory;

final class DefaultAnimalBreedStory extends Story
{
    private static array $breedsByType = [
        'dog' => ['Golden Retriever', 'Beagle', 'Labrador'],
        'cat' => ['Persian', 'Siamese', 'European'],
        'rabbit' => ['Himalayan', 'Dutch', 'Mini Rex'],
        'chicken' => ['Leghorn', 'Rhode Island Red', 'Silkie'],
    ];

    public function build(): void
    {
        foreach (self::$breedsByType as $typeName => $breeds) {
            $type = AnimalTypeFactory::find(['name' => $typeName]);
            foreach ($breeds as $breedName) {
                AnimalBreedFactory::findOrCreate(['name' => $breedName, 'type' => $type]);
            }
        }
    }
}
