<?php

namespace App\DataFixtures\Factory;

use App\Entity\Animal;
use DateTimeInterface;
use App\Entity\Enum\AnimalSexEnum;
use App\Entity\Enum\AnimalStatusEnum;
use App\DataFixtures\Provider\PetNameProvider;
use App\Entity\Enum\AnimalIdentificationTypeEnum;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Animal>
 */
final class AnimalFactory extends PersistentProxyObjectFactory
{

    public function __construct()
    {
        self::faker()->addProvider(new PetNameProvider(self::faker()));
    }

    public static function class(): string
    {
        return Animal::class;
    }

    protected function defaults(): array|callable
    {
        return [
            'createdAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTimeThisDecade()),
            'name' => self::faker()->petName(),
            'breed' => AnimalBreedFactory::new(),
            'dateOfBirth' => \DateTimeImmutable::createFromMutable(self::faker()->dateTimeThisDecade()),
            'sex' => self::faker()->randomElement(AnimalSexEnum::cases()),
            'shelter' => ShelterFactory::random(),
            'status' => self::faker()->randomElement(AnimalStatusEnum::cases()),
        ];
    }

    protected function initialize(): static
    {
        return $this;
    }
}
