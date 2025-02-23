<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Trait\CreatableTrait;
use App\Entity\Enum\AnimalStatusEnum;
use App\Entity\Enum\AnimalEventTypeEnum;
use App\Entity\Enum\AnimalReturnFromEnum;
use App\Repository\AnimalReturnRepository;
use App\Entity\Interface\AnimalEventInterface;

#[ORM\Entity(repositoryClass: AnimalReturnRepository::class)]
#[ORM\Table(name: '`animal_return`')]
#[ORM\Index(name: 'idx_animal_return_created_at', fields: ['createdAt'])]
#[ORM\HasLifecycleCallbacks]

class AnimalReturn implements AnimalEventInterface
{
    use CreatableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\ManyToOne(inversedBy: 'animalReturns')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Animal $animal = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $returnDate = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $details = null;

    #[ORM\Column(enumType: AnimalReturnFromEnum::class)]
    private ?AnimalReturnFromEnum $returnedFrom = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?AnimalEventHistory $relatedEvent = null;

    public function getEventType(): AnimalEventTypeEnum
    {
        return AnimalEventTypeEnum::ADOPTION;
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

    public function getReturnDate(): ?\DateTimeImmutable
    {
        return $this->returnDate;
    }

    public function setReturnDate(\DateTimeImmutable $returnDate): static
    {
        $this->returnDate = $returnDate;

        return $this;
    }

    public function getDetails(): ?string
    {
        return $this->details;
    }

    public function setDetails(string $details): static
    {
        $this->details = $details;

        return $this;
    }

    public function getReturnedFrom(): ?AnimalReturnFromEnum
    {
        return $this->returnedFrom;
    }

    public function setReturnedFrom(AnimalReturnFromEnum $returnedFrom): static
    {
        $this->returnedFrom = $returnedFrom;

        return $this;
    }

    public function getRelatedEvent(): ?AnimalEventHistory
    {
        return $this->relatedEvent;
    }

    public function setRelatedEvent(AnimalEventHistory $relatedEvent): static
    {
        $this->relatedEvent = $relatedEvent;

        return $this;
    }
}
