<?php

namespace App\Entity;

use App\Repository\ShelterEmployeeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ShelterEmployeeRepository::class)]
#[ORM\Table(name: '`shelter_employee`')]
class ShelterEmployee
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'shelterEmployees')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Shelter $shelter = null;

    #[ORM\OneToOne(inversedBy: 'shelterEmployee', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $employeeUser = null;

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

    public function getEmployeeUser(): ?User
    {
        return $this->employeeUser;
    }

    public function setEmployee(User $employeeUser): static
    {
        $this->employeeUser = $employeeUser;

        return $this;
    }
}
