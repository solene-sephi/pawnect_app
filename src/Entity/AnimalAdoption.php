<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Trait\CreatableTrait;
use App\Entity\Enum\AnimalStatusEnum;
use App\Entity\Enum\AnimalEventTypeEnum;
use App\Entity\Interface\AnimalEventInterface;
use App\Repository\AnimalAdoptionRepository;

#[ORM\Entity(repositoryClass: AnimalAdoptionRepository::class)]
#[ORM\Table(name: '`animal_adoption`')]
#[ORM\Index(name: 'idx_animal_adoption_created_at', fields: ['createdAt'])]
#[ORM\HasLifecycleCallbacks]

class AnimalAdoption implements AnimalEventInterface
{
    use CreatableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'animalAdoptions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Animal $animal = null;

    #[ORM\OneToOne(inversedBy: 'animalAdoption', cascade: ['persist', 'remove'])]
    private ?AdoptionRequest $adoptionRequest = null;

    public function getEventType(): AnimalEventTypeEnum
    {
        return AnimalEventTypeEnum::ADOPTION;
    }

    public function getStatus(): AnimalStatusEnum
    {
        return AnimalStatusEnum::ADOPTED;
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

    public function getAdoptionRequest(): ?AdoptionRequest
    {
        return $this->adoptionRequest;
    }

    public function setAdoptionRequest(?AdoptionRequest $adoptionRequest): static
    {
        $this->adoptionRequest = $adoptionRequest;

        return $this;
    }
}
