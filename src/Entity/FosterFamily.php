<?php

namespace App\Entity;

use App\Repository\FosterFamilyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FosterFamilyRepository::class)]
#[ORM\Table(name: '`foster_family`')]
#[ORM\Index(name: 'idx_foster_families_user_id', fields: ['fosterUser'])]
class FosterFamily
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'fosterFamily', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $fosterUser = null;

    #[ORM\Column]
    private ?bool $hasChildren = null;

    #[ORM\Column]
    private ?bool $hasOtherPets = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $details = null;

    #[ORM\Column]
    private ?int $capacity = null;

    #[ORM\Column]
    private ?bool $isAvailable = null;

    /**
     * @var Collection<int, FosterRegistry>
     */
    #[ORM\ManyToMany(targetEntity: FosterRegistry::class, mappedBy: 'FosterFamily')]
    private Collection $fosterRegistries;

    public function __construct()
    {
        $this->fosterRegistries = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFosterUser(): ?User
    {
        return $this->fosterUser;
    }

    public function setFosterUser(User $fosterUser): static
    {
        $this->fosterUser = $fosterUser;

        return $this;
    }

    public function hasChildren(): ?bool
    {
        return $this->hasChildren;
    }

    public function setHasChildren(bool $hasChildren): static
    {
        $this->hasChildren = $hasChildren;

        return $this;
    }

    public function hasOtherPets(): ?bool
    {
        return $this->hasOtherPets;
    }

    public function setHasOtherPets(bool $hasOtherPets): static
    {
        $this->hasOtherPets = $hasOtherPets;

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

    public function getCapacity(): ?int
    {
        return $this->capacity;
    }

    public function setCapacity(int $capacity): static
    {
        $this->capacity = $capacity;

        return $this;
    }

    public function isAvailable(): ?bool
    {
        return $this->isAvailable;
    }

    public function setIsAvailable(bool $isAvailable): static
    {
        $this->isAvailable = $isAvailable;

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
            $fosterRegistry->addFosterFamily($this);
        }

        return $this;
    }

    public function removeFosterRegistry(FosterRegistry $fosterRegistry): static
    {
        if ($this->fosterRegistries->removeElement($fosterRegistry)) {
            $fosterRegistry->removeFosterFamily($this);
        }

        return $this;
    }
}
