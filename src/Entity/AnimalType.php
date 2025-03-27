<?php

namespace App\Entity;

use App\Repository\AnimalTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnimalTypeRepository::class)]
#[ORM\Table(name: '`animal_type`')]
class AnimalType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    /**
     * @var Collection<int, AnimalBreed>
     */
    #[ORM\OneToMany(targetEntity: AnimalBreed::class, mappedBy: 'type', orphanRemoval: true)]
    private Collection $animalBreeds;

    public function __construct()
    {
        $this->animalBreeds = new ArrayCollection();
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

    /**
     * @return Collection<int, AnimalBreed>
     */
    public function getAnimalBreeds(): Collection
    {
        return $this->animalBreeds;
    }

    public function addAnimalBreed(AnimalBreed $animalBreed): static
    {
        if (!$this->animalBreeds->contains($animalBreed)) {
            $this->animalBreeds->add($animalBreed);
            $animalBreed->setTypes($this);
        }

        return $this;
    }

    public function removeAnimalBreed(AnimalBreed $animalBreed): static
    {
        if ($this->animalBreeds->removeElement($animalBreed)) {
            // set the owning side to null (unless already changed)
            if ($animalBreed->getTypes() === $this) {
                $animalBreed->setTypes(null);
            }
        }

        return $this;
    }
}
