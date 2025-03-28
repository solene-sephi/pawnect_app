<?php

namespace App\DataFixtures\Story;

use Zenstruck\Foundry\Story;
use App\DataFixtures\Factory\AnimalTypeFactory;

final class DefaultAnimalTypeStory extends Story
{
    private static array $typeNames = ['dog', 'cat', 'rabbit', 'chicken', 'dragon'];

    public function build(): void
    {
        foreach (self::$typeNames as $type) {
            AnimalTypeFactory::findOrCreate(['name' => $type]);
        }
    }
}
