<?php

namespace App\DataFixtures\Factory;

use App\Entity\Shelter;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Shelter>
 */
final class ShelterFactory extends PersistentProxyObjectFactory
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
        return Shelter::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'address' => AddressFactory::new(),
            'createdAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'email' => self::faker()->text(180),
            'name' => self::faker()->text(100),
            'openingHours' => self::faker()->text(255),
            'phoneNumber1' => self::faker()->text(20),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Shelter $shelter): void {})
        ;
    }
}
