<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ShelterRepository;
use App\Entity\Trait\SoftDeletableTrait;
use App\Entity\Trait\TimestampableTrait;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: ShelterRepository::class)]
#[ORM\Table(name: '`shelter`')]
#[ORM\HasLifecycleCallbacks]
#[ORM\Index(name: 'idx_shelter_active', fields: ['id'],
    options: [
        "where" => "((deleted_at IS NULL))"
    ]
)]
class Shelter
{
    use TimestampableTrait;
    use SoftDeletableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(length: 20)]
    private ?string $phoneNumber1 = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $phoneNumber2 = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $openingHours = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    /**
     * @var Collection<int, ShelterEmployee>
     */
    #[ORM\OneToMany(targetEntity: ShelterEmployee::class, mappedBy: 'shelter', orphanRemoval: true)]
    private Collection $shelterEmployees;

    /**
     * @var Collection<int, Animal>
     */
    #[ORM\OneToMany(targetEntity: Animal::class, mappedBy: 'shelter', orphanRemoval: true)]
    private Collection $animals;

    #[ORM\OneToOne(mappedBy: 'shelter', cascade: ['persist', 'remove'])]
    private ?ShelterApproval $shelterApproval = null;

    /**
     * @var Collection<int, FosterRegistry>
     */
    #[ORM\ManyToMany(targetEntity: FosterRegistry::class, mappedBy: 'shelters')]
    private Collection $fosterRegistries;

    /**
     * @var Collection<int, FosterAnimalOffer>
     */
    #[ORM\OneToMany(targetEntity: FosterAnimalOffer::class, mappedBy: 'shelter', orphanRemoval: true)]
    private Collection $fosterAnimalOffers;

    #[ORM\OneToOne(inversedBy: 'shelter', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Address $address = null;

    /**
     * @var Collection<int, AnimalArrival>
     */
    #[ORM\OneToMany(targetEntity: AnimalArrival::class, mappedBy: 'shelter', orphanRemoval: true)]
    private Collection $animalArrivals;

    public function __construct()
    {
        $this->shelterEmployees = new ArrayCollection();
        $this->animals = new ArrayCollection();
        $this->fosterRegistries = new ArrayCollection();
        $this->fosterAnimalOffers = new ArrayCollection();
        $this->animalArrivals = new ArrayCollection();
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

    public function getPhoneNumber1(): ?string
    {
        return $this->phoneNumber1;
    }

    public function setPhoneNumber1(string $phoneNumber1): static
    {
        $this->phoneNumber1 = $phoneNumber1;

        return $this;
    }

    public function getPhoneNumber2(): ?string
    {
        return $this->phoneNumber2;
    }

    public function setPhoneNumber2(?string $phoneNumber2): static
    {
        $this->phoneNumber2 = $phoneNumber2;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getOpeningHours(): ?string
    {
        return $this->openingHours;
    }

    public function setOpeningHours(string $openingHours): static
    {
        $this->openingHours = $openingHours;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, ShelterEmployee>
     */
    public function getShelterEmployees(): Collection
    {
        return $this->shelterEmployees;
    }

    public function addShelterEmployee(ShelterEmployee $shelterEmployee): static
    {
        if (!$this->shelterEmployees->contains($shelterEmployee)) {
            $this->shelterEmployees->add($shelterEmployee);
            $shelterEmployee->setShelter($this);
        }

        return $this;
    }

    public function removeShelterEmployee(ShelterEmployee $shelterEmployee): static
    {
        if ($this->shelterEmployees->removeElement($shelterEmployee)) {
            // set the owning side to null (unless already changed)
            if ($shelterEmployee->getShelter() === $this) {
                $shelterEmployee->setShelter(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Animal>
     */
    public function getAnimals(): Collection
    {
        return $this->animals;
    }

    public function addAnimal(Animal $animal): static
    {
        if (!$this->animals->contains($animal)) {
            $this->animals->add($animal);
            $animal->setShelter($this);
        }

        return $this;
    }

    public function removeAnimal(Animal $animal): static
    {
        if ($this->animals->removeElement($animal)) {
            // set the owning side to null (unless already changed)
            if ($animal->getShelter() === $this) {
                $animal->setShelter(null);
            }
        }

        return $this;
    }

    public function getShelterApproval(): ?ShelterApproval
    {
        return $this->shelterApproval;
    }

    public function setShelterApproval(ShelterApproval $shelterApproval): static
    {
        // set the owning side of the relation if necessary
        if ($shelterApproval->getShelter() !== $this) {
            $shelterApproval->setShelter($this);
        }

        $this->shelterApproval = $shelterApproval;

        return $this;
    }

    /**
     * @return Collection<int, FosterRegistry>
     */
    public function getFosterRegistries(): Collection
    {
        return $this->fosterRegistries;
    }

    public function addFosterRegistry(FosterRegistry $fosterRegistry): static
    {
        if (!$this->fosterRegistries->contains($fosterRegistry)) {
            $this->fosterRegistries->add($fosterRegistry);
            $fosterRegistry->addShelter($this);
        }

        return $this;
    }

    public function removeFosterRegistry(FosterRegistry $fosterRegistry): static
    {
        if ($this->fosterRegistries->removeElement($fosterRegistry)) {
            $fosterRegistry->removeShelter($this);
        }

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
            $fosterAnimalOffer->setShelter($this);
        }

        return $this;
    }

    public function removeFosterAnimalOffer(FosterAnimalOffer $fosterAnimalOffer): static
    {
        if ($this->fosterAnimalOffers->removeElement($fosterAnimalOffer)) {
            // set the owning side to null (unless already changed)
            if ($fosterAnimalOffer->getShelter() === $this) {
                $fosterAnimalOffer->setShelter(null);
            }
        }

        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(Address $address): static
    {
        $this->address = $address;

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
            $animalArrival->setShelter($this);
        }

        return $this;
    }

    public function removeAnimalArrival(AnimalArrival $animalArrival): static
    {
        if ($this->animalArrivals->removeElement($animalArrival)) {
            // set the owning side to null (unless already changed)
            if ($animalArrival->getShelter() === $this) {
                $animalArrival->setShelter(null);
            }
        }

        return $this;
    }
}
