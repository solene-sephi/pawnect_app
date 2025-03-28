<?php

namespace App\Entity;

use App\Entity\Enum\AnimalStatusEnum;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Enum\AnimalSexEnum;
use App\Repository\AnimalRepository;
use App\Entity\Trait\SoftDeletableTrait;
use App\Entity\Trait\TimestampableTrait;
use App\Entity\Enum\AnimalIdentificationTypeEnum;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AnimalRepository::class)]
#[ORM\Table(name: '`animal`')]
#[ORM\HasLifecycleCallbacks]
#[ORM\Index(name: 'idx_animal_active', fields: ['id'],
    options: [
        "where" => "((deleted_at IS NULL))"
    ]
)]
#[ORM\Index(name: 'idx_animal_identification_number', fields: ['identificationNumber'])]
#[Assert\Cascade]
class Animal
{
    use TimestampableTrait;
    use SoftDeletableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 100)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'animals')]
    #[ORM\JoinColumn(nullable: false)]
    private ?AnimalBreed $breed = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    #[Assert\NotBlank]
    #[Assert\DateTime]
    private ?\DateTimeImmutable $dateOfBirth = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(max: 255)]
    private ?string $identificationNumber = null;

    #[ORM\Column(enumType: AnimalIdentificationTypeEnum::class, nullable: true)]
    #[Assert\NotBlank]
    #[Assert\Choice(callback: 'getIdentificationTypes')]
    private ?AnimalIdentificationTypeEnum $identificationType = null;

    #[ORM\Column(enumType: AnimalSexEnum::class)]
    #[Assert\NotBlank]
    #[Assert\Choice(callback: 'getSexes')]
    private ?AnimalSexEnum $sex = null;

    #[ORM\ManyToOne(inversedBy: 'animals')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Shelter $shelter = null;

    /**
     * @var Collection<int, FosterAnimalOffer>
     */
    #[ORM\OneToMany(targetEntity: FosterAnimalOffer::class, mappedBy: 'animal', orphanRemoval: true)]
    private Collection $fosterAnimalOffers;

    #[ORM\OneToOne(mappedBy: 'animal', cascade: ['persist', 'remove'])]
    private ?AnimalDetail $animalDetail = null;

    /**
     * @var Collection<int, AnimalPicture>
     */
    #[ORM\OneToMany(targetEntity: AnimalPicture::class, mappedBy: 'animal', orphanRemoval: true)]
    private Collection $animalPictures;

    /**
     * @var Collection<int, AnimalEventHistory>
     */
    #[ORM\OneToMany(targetEntity: AnimalEventHistory::class, mappedBy: 'animal', orphanRemoval: true)]
    private Collection $animalEventHistories;

    /**
     * @var Collection<int, AdoptionRequest>
     */
    #[ORM\OneToMany(targetEntity: AdoptionRequest::class, mappedBy: 'animal', orphanRemoval: true)]
    private Collection $adoptionRequests;

    #[ORM\Column(enumType: AnimalStatusEnum::class)]
    #[Assert\NotBlank]
    #[Assert\Choice(callback: 'getStatuses')]
    private ?AnimalStatusEnum $status = null;

    /**
     * @var Collection<int, AnimalAdoption>
     */
    #[ORM\OneToMany(targetEntity: AnimalAdoption::class, mappedBy: 'animal', orphanRemoval: true)]
    private Collection $animalAdoptions;

    /**
     * @var Collection<int, AnimalArrival>
     */
    #[ORM\OneToMany(targetEntity: AnimalArrival::class, mappedBy: 'animal', orphanRemoval: true)]
    private Collection $animalArrivals;

    /**
     * @var Collection<int, AnimalFosterPlacement>
     */
    #[ORM\OneToMany(targetEntity: AnimalFosterPlacement::class, mappedBy: 'animal', orphanRemoval: true)]
    private Collection $animalFosterPlacements;

    /**
     * @var Collection<int, AnimalReturn>
     */
    #[ORM\OneToMany(targetEntity: AnimalReturn::class, mappedBy: 'animal', orphanRemoval: true)]
    private Collection $animalReturns;

    public function __construct()
    {
        $this->fosterAnimalOffers = new ArrayCollection();
        $this->animalPictures = new ArrayCollection();
        $this->animalEventHistories = new ArrayCollection();
        $this->adoptionRequests = new ArrayCollection();
        $this->animalAdoptions = new ArrayCollection();
        $this->animalArrivals = new ArrayCollection();
        $this->animalFosterPlacements = new ArrayCollection();
        $this->animalReturns = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, FosterAnimalOffer>
     */
    public function getFosterAnimalOffers(): Collection
    {
        return $this->fosterAnimalOffers;
    }

    public function addFosterAnimalOffer(FosterAnimalOffer $fosterAnimalOffer): static
    {
        if (!$this->fosterAnimalOffers->contains($fosterAnimalOffer)) {
            $this->fosterAnimalOffers->add($fosterAnimalOffer);
            $fosterAnimalOffer->setAnimal($this);
        }

        return $this;
    }

    public function removeFosterAnimalOffer(FosterAnimalOffer $fosterAnimalOffer): static
    {
        if ($this->fosterAnimalOffers->removeElement($fosterAnimalOffer)) {
            // set the owning side to null (unless already changed)
            if ($fosterAnimalOffer->getAnimal() === $this) {
                $fosterAnimalOffer->setAnimal(null);
            }
        }

        return $this;
    }

    public function getAnimalDetail(): ?AnimalDetail
    {
        return $this->animalDetail;
    }

    public function setAnimalDetail(AnimalDetail $animalDetail): static
    {
        // set the owning side of the relation if necessary
        if ($animalDetail->getAnimal() !== $this) {
            $animalDetail->setAnimal($this);
        }

        $this->animalDetail = $animalDetail;

        return $this;
    }

    /**
     * @return Collection<int, AnimalPicture>
     */
    public function getAnimalPictures(): Collection
    {
        return $this->animalPictures;
    }

    public function addAnimalPicture(AnimalPicture $animalPicture): static
    {
        if (!$this->animalPictures->contains($animalPicture)) {
            $this->animalPictures->add($animalPicture);
            $animalPicture->setAnimal($this);
        }

        return $this;
    }

    public function removeAnimalPicture(AnimalPicture $animalPicture): static
    {
        if ($this->animalPictures->removeElement($animalPicture)) {
            // set the owning side to null (unless already changed)
            if ($animalPicture->getAnimal() === $this) {
                $animalPicture->setAnimal(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, AnimalEventHistory>
     */
    public function getAnimalEventHistories(): Collection
    {
        return $this->animalEventHistories;
    }

    /**
     * @return Collection<int, AdoptionRequest>
     */
    public function getAdoptionRequests(): Collection
    {
        return $this->adoptionRequests;
    }

    public function addAdoptionRequest(AdoptionRequest $adoptionRequest): static
    {
        if (!$this->adoptionRequests->contains($adoptionRequest)) {
            $this->adoptionRequests->add($adoptionRequest);
            $adoptionRequest->setAnimal($this);
        }

        return $this;
    }

    public function removeAdoptionRequest(AdoptionRequest $adoptionRequest): static
    {
        if ($this->adoptionRequests->removeElement($adoptionRequest)) {
            // set the owning side to null (unless already changed)
            if ($adoptionRequest->getAnimal() === $this) {
                $adoptionRequest->setAnimal(null);
            }
        }

        return $this;
    }

    public function getStatus(): ?AnimalStatusEnum
    {
        return $this->status;
    }

    public function setStatus(AnimalStatusEnum $status): static
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, AnimalAdoption>
     */
    public function getAnimalAdoptions(): Collection
    {
        return $this->animalAdoptions;
    }

    public function addAnimalAdoption(AnimalAdoption $animalAdoption): static
    {
        if (!$this->animalAdoptions->contains($animalAdoption)) {
            $this->animalAdoptions->add($animalAdoption);
            $animalAdoption->setAnimal($this);
        }

        return $this;
    }

    public function removeAnimalAdoption(AnimalAdoption $animalAdoption): static
    {
        if ($this->animalAdoptions->removeElement($animalAdoption)) {
            // set the owning side to null (unless already changed)
            if ($animalAdoption->getAnimal() === $this) {
                $animalAdoption->setAnimal(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, AnimalArrival>
     */
    public function getAnimalArrivals(): Collection
    {
        return $this->animalArrivals;
    }

    public function addAnimalArrival(AnimalArrival $animalArrival): static
    {
        if (!$this->animalArrivals->contains($animalArrival)) {
            $this->animalArrivals->add($animalArrival);
            $animalArrival->setAnimal($this);
        }

        return $this;
    }

    public function removeAnimalArrival(AnimalArrival $animalArrival): static
    {
        if ($this->animalArrivals->removeElement($animalArrival)) {
            // set the owning side to null (unless already changed)
            if ($animalArrival->getAnimal() === $this) {
                $animalArrival->setAnimal(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, AnimalFosterPlacement>
     */
    public function getAnimalFosterPlacements(): Collection
    {
        return $this->animalFosterPlacements;
    }

    public function addAnimalFosterPlacement(AnimalFosterPlacement $animalFosterPlacement): static
    {
        if (!$this->animalFosterPlacements->contains($animalFosterPlacement)) {
            $this->animalFosterPlacements->add($animalFosterPlacement);
            $animalFosterPlacement->setAnimal($this);
        }

        return $this;
    }

    public function removeAnimalFosterPlacement(AnimalFosterPlacement $animalFosterPlacement): static
    {
        if ($this->animalFosterPlacements->removeElement($animalFosterPlacement)) {
            // set the owning side to null (unless already changed)
            if ($animalFosterPlacement->getAnimal() === $this) {
                $animalFosterPlacement->setAnimal(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, AnimalReturn>
     */
    public function getAnimalReturns(): Collection
    {
        return $this->animalReturns;
    }

    public function addAnimalReturn(AnimalReturn $animalReturn): static
    {
        if (!$this->animalReturns->contains($animalReturn)) {
            $this->animalReturns->add($animalReturn);
            $animalReturn->setAnimal($this);
        }

        return $this;
    }

    public function removeAnimalReturn(AnimalReturn $animalReturn): static
    {
        if ($this->animalReturns->removeElement($animalReturn)) {
            // set the owning side to null (unless already changed)
            if ($animalReturn->getAnimal() === $this) {
                $animalReturn->setAnimal(null);
            }
        }

        return $this;
    }

    public static function getIdentificationTypes(): array
    {
        return array_column(AnimalIdentificationTypeEnum::cases(), 'value');

    }
    public static function getSexes(): array
    {
        return array_column(AnimalSexEnum::cases(), 'value');

    }

    public static function getStatuses(): array
    {
        return array_column(AnimalStatusEnum::cases(), 'value');

    }
}
