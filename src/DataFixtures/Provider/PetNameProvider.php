<?php

namespace App\DataFixtures\Provider;

class PetNameProvider extends \Faker\Provider\Base
{
    protected static $petNames = [
        'Ace',
        'Archie',
        'Bailey',
        'Bandit',
        'Bella',
        'Bentley',
        'Bruno',
        'Buddy',
        'Charlie',
        'Coco',
        'Cookie',
        'Cooper',
        'Daisy',
        'Dixie',
        'Finn',
        'Ginger',
        'Gracie',
        'Gus',
        'Hank',
        'Jack',
        'Jax',
        'Joey',
        'Kobe',
        'Leo',
        'Lola',
        'Louie',
        'Lucy',
        'Maggie',
        'Max',
        'Mia',
        'Milo',
        'Molly',
        'Murphey',
        'Nala',
        'Nova',
        'Ollie',
        'Oreo',
        'Rosie',
        'Scout',
        'Stella',
        'Teddy',
        'Tuffy'
    ];

    public function petName()
    {
        $format = static::randomElement(static::$petNames);
        return $this->generator->parse($format);
    }
}