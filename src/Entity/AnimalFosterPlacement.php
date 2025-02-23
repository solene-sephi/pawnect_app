<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Trait\CreatableTrait;
use App\Entity\Enum\AnimalStatusEnum;
use App\Entity\Enum\AnimalEventTypeEnum;
use App\Entity\Interface\AnimalEventInterface;
use App\Repository\AnimalFosterPlacementRepository;

#[ORM\Entity(repositoryClass: AnimalFosterPlacementRepository::class)]
#[ORM\Table(name: '`animal_foster_placement`')]
#[ORM\Index(name: 'idx_animal_foster_placement_created_at', fields: ['createdAt'])]
#[ORM\HasLifecycleCallbacks]

class AnimalFosterPlacement implements AnimalEventInterface
{
    use CreatableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'animalFosterPlacements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Animal $animal = null;

    #[ORM\ManyToOne(inversedBy: 'animalFosterPlacements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?FosterFamily $fosterFamily = null;

    #[ORM\OneToOne(inversedBy: 'animalFosterPlacement', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?FosterAnimalOffer $fosterOffer = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $startDate = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $endDate = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $comment = null;

    public function getEventType(): AnimalEventTypeEnum
    {
        return AnimalEventTypeEnum::FOSTER_PLACEMENT;
    }

    public function getStatus(): AnimalStatusEnum
    {
        return AnimalStatusEnum::IN_FOSTER_CARE;
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

    public function getFosterFamily(): ?FosterFamily
    {
        return $this->fosterFamily;
    }

    public function setFosterFamily(?FosterFamily $fosterFamily): static
    {
        $this->fosterFamily = $fosterFamily;

        return $this;
    }

    public function getFosterOffer(): ?FosterAnimalOffer
    {
        return $this->fosterOffer;
    }

    public function setFosterOffer(FosterAnimalOffer $fosterOffer): static
    {
        $this->fosterOffer = $fosterOffer;

        return $this;
    }

    public function getStartDate(): ?\DateTimeImmutable
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeImmutable $startDate): static
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeImmutable
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeImmutable $endDate): static
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): static
    {
        $this->comment = $comment;

        return $this;
    }
}
