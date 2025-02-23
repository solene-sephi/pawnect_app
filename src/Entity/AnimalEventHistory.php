<?php

namespace App\Entity;

use App\Entity\Enum\AnimalEventTypeEnum;
use App\Repository\AnimalEventHistoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnimalEventHistoryRepository::class)]
#[ORM\Table(name: '`animal_event_history`')]
#[ORM\Index(name: 'idx_animal_event_history_created_at', fields: ['createdAt'])]
class AnimalEventHistory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'animalEventHistories')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Animal $animal = null;

    #[ORM\Column(enumType: AnimalEventTypeEnum::class)]
    private ?AnimalEventTypeEnum $eventType = null;

    #[ORM\Column]
    private ?int $eventId = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    public function __construct(Animal $animal, AnimalEventTypeEnum $eventType, int $eventId, \DateTimeImmutable $createdAt)
    {
        $this->animal = $animal;
        $this->eventType = $eventType;
        $this->eventId = $eventId;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnimal(): ?Animal
    {
        return $this->animal;
    }

    public function getEventType(): ?AnimalEventTypeEnum
    {
        return $this->eventType;
    }

    public function getEventId(): ?int
    {
        return $this->eventId;
    }
}
