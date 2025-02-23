<?php

namespace App\Entity;

use App\Entity\Enum\GeneralStatusEnum;
use App\Repository\FosterRegistryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FosterRegistryRepository::class)]
#[ORM\HasLifecycleCallbacks]

class FosterRegistry
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, Shelter>
     */
    #[ORM\ManyToMany(targetEntity: Shelter::class, inversedBy: 'fosterRegistries')]
    private Collection $shelters;

    /**
     * @var Collection<int, FosterFamily>
     */
    #[ORM\ManyToMany(targetEntity: FosterFamily::class, inversedBy: 'fosterRegistries')]
    private Collection $fosterFamilies;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $comment = null;

    #[ORM\Column(enumType: GeneralStatusEnum::class)]
    private ?GeneralStatusEnum $status = null;

    public function __construct()
    {
        $this->shelters = new ArrayCollection();
        $this->fosterFamily = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Shelter>
     */
    public function getShelter(): Collection
    {
        return $this->shelter;
    }

    public function addShelter(Shelter $shelter): static
    {
        if (!$this->shelter->contains($shelter)) {
            $this->shelter->add($shelter);
        }

        return $this;
    }

    public function removeShelter(Shelter $shelter): static
    {
        $this->shelter->removeElement($shelter);

        return $this;
    }

    /**
     * @return Collection<int, FosterFamily>
     */
    public function getFosterFamily(): Collection
    {
        return $this->fosterFamily;
    }

    public function addFosterFamily(FosterFamily $fosterFamily): static
    {
        if (!$this->fosterFamily->contains($fosterFamily)) {
            $this->fosterFamily->add($fosterFamily);
        }

        return $this;
    }

    public function removeFosterFamily(FosterFamily $fosterFamily): static
    {
        $this->fosterFamily->removeElement($fosterFamily);

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
