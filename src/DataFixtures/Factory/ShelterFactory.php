<?php

namespace App\DataFixtures\Factory;

use App\Entity\Shelter;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Shelter>
 */
final class ShelterFactory extends PersistentProxyObjectFactory
{

    public function __construct()
    {
    }

    public static function class(): string
    {
        return Shelter::class;
    }

    protected function defaults(): array|callable
    {
        return [
            'createdAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'address' => AddressFactory::new(),
            'name' => self::faker()->company(),
            'phoneNumber1' => self::faker()->phoneNumber(),
            'email' => self::faker()->safeEmail(),
            'openingHours' => self::faker()->text(maxNbChars: 30),
        ];
    }

    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Shelter $shelter): void {})
        ;
    }
}
