<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Enum\AnimalSexEnum;
use App\Repository\AnimalRepository;
use App\Entity\Trait\SoftDeletableTrait;
use App\Entity\Trait\TimestampableTrait;
use App\Entity\Enum\AnimalIdentificationTypeEnum;

#[ORM\Entity(repositoryClass: AnimalRepository::class)]
#[ORM\Table(name: '`animal`')]
#[ORM\HasLifecycleCallbacks]
#[ORM\Index(name: 'idx_animal_active', fields: ['id'],
    options: [
        "where" => "((deleted_at IS NULL))"
    ]
)]
#[ORM\Index(name: 'idx_animals_identification_number', columns: ['identificationNumber'])]
class Animal
{
    use TimestampableTrait;
    use SoftDeletableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'animals')]
    #[ORM\JoinColumn(nullable: false)]
    private ?AnimalBreed $breed = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $dateOfBirth = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $identificationNumber = null;

    #[ORM\Column(enumType: AnimalIdentificationTypeEnum::class)]
    private ?AnimalIdentificationTypeEnum $identificationType = null;

    #[ORM\Column(enumType: AnimalSexEnum::class)]
    private ?AnimalSexEnum $sex = null;

    #[ORM\ManyToOne(inversedBy: 'animals')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Shelter $shelter = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getBreed(): ?AnimalBreed
    {
        return $this->breed;
    }

    public function setBreed(?AnimalBreed $breed): static
    {
        $this->breed = $breed;

        return $this;
    }

    public function getDateOfBirth(): ?\DateTimeImmutable
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(\DateTimeImmutable $dateOfBirth): static
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    public function getIdentificationNumber(): ?string
    {
        return $this->identificationNumber;
    }

    public function setIdentificationNumber(?string $identificationNumber): static
    {
        $this->identificationNumber = $identificationNumber;

        return $this;
    }

    public function getIdentificationType(): ?AnimalIdentificationTypeEnum
    {
        return $this->identificationType;
    }

    public function setIdentificationType(AnimalIdentificationTypeEnum $identificationType): static
    {
        $this->identificationType = $identificationType;

        return $this;
    }

    public function getSex(): ?AnimalSexEnum
    {
        return $this->sex;
    }

    public function setSex(AnimalSexEnum $sex): static
    {
        $this->sex = $sex;

        return $this;
    }

    public function getShelter(): ?Shelter
    {
        return $this->shelter;
    }

    public function setShelter(?Shelter $shelter): static
    {
        $this->shelter = $shelter;

        return $this;
    }
}
