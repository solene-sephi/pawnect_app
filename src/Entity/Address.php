<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\AddressRepository;
use App\Entity\Trait\TimestampableTrait;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AddressRepository::class)]
#[ORM\Table(name: '`address`')]
#[ORM\HasLifecycleCallbacks]
#[ORM\Index(name: 'idx_address_zip_code', fields: ['zipCode'])]
#[ORM\Index(name: 'idx_address_city', fields: ['city'])]
#[Assert\Cascade]
class Address
{
    use TimestampableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 5000)]
    private ?string $street = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 100)]
    private ?string $city = null;

    #[ORM\Column(length: 100)]
    #[Assert\EqualTo(value: "France", message: "The country must be France.")]
    private ?string $country = "France";

    #[ORM\Column(length: 20)]
    #[Assert\NotBlank]
    #[Assert\Length(exactly: 5)]
    #[Assert\Regex("/^[0-9]{5}$/", message: "Please enter a valid zip code with 5 digits.")]
    private ?string $zipCode = null;

    #[ORM\OneToOne(mappedBy: 'address', cascade: ['persist', 'remove'])]
    private ?User $residentUser = null;

    #[ORM\OneToOne(mappedBy: 'address', cascade: ['persist', 'remove'])]
    private ?Shelter $shelter = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): static
    {
        $this->street = $street;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function setZipCode(string $zipCode): static
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getResident(): ?User
    {
        return $this->resident;
    }

    public function setResident(?User $resident): static
    {
        // unset the owning side of the relation if necessary
        if ($resident === null && $this->resident !== null) {
            $this->resident->setAddress(null);
        }

        // set the owning side of the relation if necessary
        if ($resident !== null && $resident->getAddress() !== $this) {
            $resident->setAddress($this);
        }

        $this->resident = $resident;

        return $this;
    }

    public function getShelter(): ?Shelter
    {
        return $this->shelter;
    }

    public function setShelter(Shelter $shelter): static
    {
        // set the owning side of the relation if necessary
        if ($shelter->getAddress() !== $this) {
            $shelter->setAddress($this);
        }

        $this->shelter = $shelter;

        return $this;
    }
}
