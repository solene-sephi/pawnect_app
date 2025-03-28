<?php

namespace App\DataFixtures\Factory;

use App\Entity\Animal;
use App\Entity\Enum\AnimalSexEnum;
use App\Entity\Enum\AnimalStatusEnum;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Animal>
 */
final class AnimalFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
    }

    public static function class(): string
    {
        return Animal::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'breed' => null, // TODO add App\Entity\AnimalBreed type manually
            'createdAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'dateOfBirth' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'name' => self::faker()->text(100),
            'sex' => self::faker()->randomElement(AnimalSexEnum::cases()),
            'shelter' => ShelterFactory::new(),
            'status' => self::faker()->randomElement(AnimalStatusEnum::cases()),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Animal $animal): void {})
        ;
    }
}
