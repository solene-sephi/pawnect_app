<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Trait\CreatableTrait;
use App\Entity\Enum\AnimalStatusEnum;
use App\Entity\Enum\AnimalEventTypeEnum;
use App\Repository\AnimalArrivalRepository;
use App\Entity\Interface\AnimalEventInterface;

#[ORM\Entity(repositoryClass: AnimalArrivalRepository::class)]
#[ORM\Table(name: '`animal_arrival`')]
#[ORM\Index(name: 'idx_animal_arrival_created_at', fields: ['createdAt'])]
#[ORM\HasLifecycleCallbacks]

class AnimalArrival implements AnimalEventInterface
{
    use CreatableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'animalArrivals')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Animal $animal = null;

    #[ORM\ManyToOne(inversedBy: 'animalArrivals')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Shelter $shelter = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $reason = null;

    public function getEventType(): AnimalEventTypeEnum
    {
        return AnimalEventTypeEnum::ARRIVAL;
    }

    public function getStatus(): AnimalStatusEnum
    {
        return AnimalStatusEnum::AVAILABLE_FOR_ADOPTION;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnimal(): ?Animal
    {
        return $this->animal;
    }

    public function setAnimal(?Animal $animal): static
    {
        $this->animal = $animal;

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

    public function getReason(): ?string
    {
        return $this->reason;
    }

    public function setReason(?string $reason): static
    {
        $this->reason = $reason;

        return $this;
    }
}
