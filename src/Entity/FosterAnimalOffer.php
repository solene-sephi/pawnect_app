<?php

namespace App\Entity;

use App\Entity\Enum\GeneralStatusEnum;
use App\Entity\Trait\BlameableTrait;
use App\Entity\Trait\SoftDeletableTrait;
use App\Entity\Trait\TimestampableTrait;
use App\Repository\FosterAnimalOfferRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FosterAnimalOfferRepository::class)]
#[ORM\Table(name: '`foster_animal_offer`')]
#[ORM\HasLifecycleCallbacks]
#[ORM\Index(name: 'idx_foster_animal_offer_shelter', fields: ['shelter'])]
#[ORM\Index(name: 'idx_foster_animal_offer_foster_family', fields: ['fosterFamily'])]
#[ORM\Index(name: 'idx_foster_animal_offer_animal', fields: ['animal'])]
#[ORM\Index(name: 'idx_foster_animal_offer_created_at', fields: ['createdAt'])]
class FosterAnimalOffer
{
    use TimestampableTrait;
    use BlameableTrait;
    use SoftDeletableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'fosterAnimalOffers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Shelter $shelter = null;

    #[ORM\ManyToOne(inversedBy: 'fosterAnimalOffers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?FosterFamily $fosterFamily = null;

    #[ORM\ManyToOne(inversedBy: 'fosterAnimalOffers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Animal $animal = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $respondedAt = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $comment = null;

    #[ORM\OneToOne(mappedBy: 'fosterOffer', cascade: ['persist', 'remove'])]
    private ?AnimalFosterPlacement $animalFosterPlacement = null;

    #[ORM\Column(enumType: GeneralStatusEnum::class)]
    private ?GeneralStatusEnum $status = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getFosterFamily(): ?FosterFamily
    {
        return $this->fosterFamily;
    }

    public function setFosterFamily(?FosterFamily $fosterFamily): static
    {
        $this->fosterFamily = $fosterFamily;

        return $this;
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

    public function getRespondedAt(): ?\DateTimeImmutable
    {
        return $this->respondedAt;
    }

    public function setRespondedAt(?\DateTimeImmutable $respondedAt): static
    {
        $this->respondedAt = $respondedAt;

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

    public function getAnimalFosterPlacement(): ?AnimalFosterPlacement
    {
        return $this->animalFosterPlacement;
    }

    public function setAnimalFosterPlacement(AnimalFosterPlacement $animalFosterPlacement): static
    {
        // set the owning side of the relation if necessary
        if ($animalFosterPlacement->getFosterOffer() !== $this) {
            $animalFosterPlacement->setFosterOffer($this);
        }

        $this->animalFosterPlacement = $animalFosterPlacement;

        return $this;
    }

    public function getStatus(): ?GeneralStatusEnum
    {
        return $this->status;
    }

    public function setStatus(GeneralStatusEnum $status): static
    {
        $this->status = $status;

        return $this;
    }
}
