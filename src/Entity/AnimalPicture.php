<?php

namespace App\Entity;

use App\Repository\AnimalPictureRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnimalPictureRepository::class)]
#[ORM\Table(name: '`animal_image`')]
#[ORM\Index(name: 'idx_animal_image_animal', fields: ['animal'])]
class AnimalPicture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'animalPictures')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Animal $animal = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $filepath = null;

    #[ORM\Column(length: 255)]
    private ?string $filename = null;

    #[ORM\Column]
    private ?int $imageOrder = null;

    #[ORM\Column]
    private ?bool $isMainPicture = null;

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

    public function getFilepath(): ?string
    {
        return $this->filepath;
    }

    public function setFilepath(string $filepath): static
    {
        $this->filepath = $filepath;

        return $this;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): static
    {
        $this->filename = $filename;

        return $this;
    }

    public function getImageOrder(): ?int
    {
        return $this->imageOrder;
    }

    public function setImageOrder(int $imageOrder): static
    {
        $this->imageOrder = $imageOrder;

        return $this;
    }

    public function isMainPicture(): ?bool
    {
        return $this->isMainPicture;
    }

    public function setIsMainPicture(bool $isMainPicture): static
    {
        $this->isMainPicture = $isMainPicture;

        return $this;
    }
}
