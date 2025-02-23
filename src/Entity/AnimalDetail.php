<?php

namespace App\Entity;

use App\Repository\AnimalDetailRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnimalDetailRepository::class)]
#[ORM\Table(name: 'animal_detail')]
#[ORM\Index(name: 'idx_animal_detail_animal', fields: ['animal'])]
class AnimalDetail
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'animalDetail', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Animal $animal = null;

    #[ORM\Column(nullable: true)]
    private ?bool $needsVisitBeforeAdoption = null;

    #[ORM\Column(nullable: true)]
    private ?bool $canLiveWithDogs = null;

    #[ORM\Column(nullable: true)]
    private ?bool $canLiveWithCats = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $compatibilityNotes = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $behaviorNotes = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isSterilized = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 3, nullable: true)]
    private ?string $weight = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 3, nullable: true)]
    private ?string $height = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnimal(): ?Animal
    {
        return $this->animal;
    }

    public function setAnimal(Animal $animal): static
    {
        $this->animal = $animal;

        return $this;
    }

    public function isNeedsVisitBeforeAdoption(): ?bool
    {
        return $this->needsVisitBeforeAdoption;
    }

    public function setNeedsVisitBeforeAdoption(?bool $needsVisitBeforeAdoption): static
    {
        $this->needsVisitBeforeAdoption = $needsVisitBeforeAdoption;

        return $this;
    }

    public function isCanLiveWithDogs(): ?bool
    {
        return $this->canLiveWithDogs;
    }

    public function setCanLiveWithDogs(?bool $canLiveWithDogs): static
    {
        $this->canLiveWithDogs = $canLiveWithDogs;

        return $this;
    }

    public function isCanLiveWithCats(): ?bool
    {
        return $this->canLiveWithCats;
    }

    public function setCanLiveWithCats(?bool $canLiveWithCats): static
    {
        $this->canLiveWithCats = $canLiveWithCats;

        return $this;
    }

    public function getCompatibilityNotes(): ?string
    {
        return $this->compatibilityNotes;
    }

    public function setCompatibilityNotes(?string $compatibilityNotes): static
    {
        $this->compatibilityNotes = $compatibilityNotes;

        return $this;
    }

    public function getBehaviorNotes(): ?string
    {
        return $this->behaviorNotes;
    }

    public function setBehaviorNotes(?string $behaviorNotes): static
    {
        $this->behaviorNotes = $behaviorNotes;

        return $this;
    }

    public function isSterilized(): ?bool
    {
        return $this->isSterilized;
    }

    public function setIsSterilized(?bool $isSterilized): static
    {
        $this->isSterilized = $isSterilized;

        return $this;
    }

    public function getWeight(): ?string
    {
        return $this->weight;
    }

    public function setWeight(?string $weight): static
    {
        $this->weight = $weight;

        return $this;
    }

    public function getHeight(): ?string
    {
        return $this->height;
    }

    public function setHeight(?string $height): static
    {
        $this->height = $height;

        return $this;
    }
}
