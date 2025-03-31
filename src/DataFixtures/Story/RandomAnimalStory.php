<?php

namespace App\DataFixtures\Story;

use App\DataFixtures\Factory\AnimalBreedFactory;
use App\DataFixtures\Factory\ShelterFactory;
use DateTimeImmutable;
use Zenstruck\Foundry\Story;
use function Zenstruck\Foundry\faker;
use App\DataFixtures\Factory\AnimalFactory;
use App\Entity\Enum\AnimalIdentificationTypeEnum;

final class RandomAnimalStory extends Story
{
    public function build(): void
    {
        // loads the state defined in DefaultAnimalTypeStory::build() to load all animal types
        DefaultAnimalTypeStory::load();
        // loads the state defined in DefaultAnimalBreedStory::build() to load all animal breeds
        DefaultAnimalBreedStory::load();

        // Create 70 animals with random attributes
        AnimalFactory::new()
            ->with(function () {
                return [
                    'createdAt' => $created_at = $this->randomCreatedAt(),
                    'updatedAt' => $updated_at = $this->randomUpdatedAt($created_at),
                    'deletedAt' => $this->randomDeletedAt($created_at, $updated_at),
                    'breed' => AnimalBreedFactory::random(),
                    'shelter' => ShelterFactory::random(),
                ];
            })
            ->with(function () {
                return $this->randomIdentification();
            })
            ->many(70)
            ->create();
    }

    /**
     * Generates a random creation date for the animal.
     * NOTE: Disable PrePersist event in TimestampableTrait temporarily during data population in development.
     * @return DateTimeImmutable A random date within the past decade.
     */

    private function randomCreatedAt(): DateTimeImmutable
    {
        return DateTimeImmutable::createFromMutable(faker()->dateTimeThisDecade());
    }

    /**
     * Generates a random update date for the animal.
     * The update date will be between the created date and the current time.
     * NOTE: Disable PreUpdate event in TimestampableTrait temporarily during data population in development.
     *
     * @param \DateTimeImmutable $created_at The creation date of the animal.
     * @return DateTimeImmutable|null The update date or null (90% chance of being null).
     */
    private function randomUpdatedAt(DateTimeImmutable $created_at): ?DateTimeImmutable
    {
        return faker()->boolean(90) ? DateTimeImmutable::createFromMutable(faker()->dateTimeBetween($created_at->format('Y-m-d H:i:s'), 'now')) : null;
    }

    /**
     * Generates a random deletion date for the animal.
     * The deletion date will be between the updated date (if it exists) or the created date, and the current time.
     * 
     * @param \DateTimeImmutable $created_at The creation date of the animal.
     * @param \DateTimeImmutable|null $updated_at The update date of the animal, or null if it doesn't exist.
     * @return DateTimeImmutable|null The deletion date or null (10% chance of being deleted).
     */
    private function randomDeletedAt(DateTimeImmutable $created_at, ?DateTimeImmutable $updated_at): ?DateTimeImmutable
    {
        // For the deletion date to be after the last timeable event
        $lastDate = $updated_at !== null ? $updated_at : $created_at;

        return faker()->boolean(10) ? DateTimeImmutable::createFromMutable(faker()->dateTimeBetween($lastDate->format('Y-m-d H:i:s'), 'now')) : null;
    }

    /**
     * Generates random identification data for the animal.
     * This method selects randomly between several identification types: microchip, tattoo, or no identification.
     * 
     * @return array Random identification data with type and number.
     */
    private function randomIdentificationType(): AnimalIdentificationTypeEnum
    {
        return faker()->boolean(90) ? faker()->randomElement(AnimalIdentificationTypeEnum::cases()) : null;
    }

    /**
     * Generates random identification data for the animal.
     * This method selects randomly between several identification types: microchip, tattoo, or no identification.
     * 
     * @return array Random identification data with type and number.
     */
    private function randomIdentification(): array
    {
        $choices = [
            'identifiedWithMicrochip',
            'identifiedWithTattoo',
            'notIdentified'
        ];

        $randomChoice = faker()->randomElement($choices);

        return $this->{$randomChoice}();
    }

    /**
     * Generates identification data for animals that are not identified.
     * 
     * @return array Identification data with null values for type and number.
     */
    private function notIdentified(): array
    {
        return [
            'identificationType' => null,
            'identificationNumber' => null,
        ];
    }

    /**
     * Generates identification data for animals identified by microchip.
     * 
     * @return array Identification data with a microchip type and a random 9-digit number.
     */
    public function identifiedWithMicrochip(): array
    {
        return [
            'identificationType' => AnimalIdentificationTypeEnum::MICROCHIP,
            'identificationNumber' => faker()->randomNumber(9, true),
        ];
    }

    /**
     * Generates identification data for animals identified by tattoo.
     * 
     * @return array Identification data with a tattoo type and a random pattern of letters and digits.
     */
    public function identifiedWithTattoo(): array
    {
        return [
            'identificationType' => AnimalIdentificationTypeEnum::TATTOO,
            'identificationNumber' => faker()->bothify('???-#####'),
        ];
    }

    /**
     * Generates identification data for animals identified by internal ID.
     * 
     * @return array Identification data with an internal ID type and a random 6-digit number.
     */
    public function identifiedWithInternalId(): array
    {
        return [
            'identificationType' => AnimalIdentificationTypeEnum::INTERNAL_ID,
            'identificationNumber' => faker()->randomNumber(6, true),
        ];
    }

    /**
     * Generates identification data for animals identified with another method.
     * 
     * @return array Identification data with a custom 'other' type and a random word as number.
     */
    public function identifiedWithOther(): array
    {
        return [
            'identificationType' => AnimalIdentificationTypeEnum::OTHER,
            'identificationNumber' => self::faker()->word(),
        ];
    }
}
