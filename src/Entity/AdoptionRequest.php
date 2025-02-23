<?php

namespace App\Entity;

use App\Entity\Trait\BlameableTrait;
use App\Entity\Trait\TimestampableTrait;
use App\Repository\AdoptionRequestRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdoptionRequestRepository::class)]
#[ORM\Table(name: '`adoption_request`')]
#[ORM\Index(name: 'idx_animal_arrival_user', fields: ['requester'])]
#[ORM\Index(name: 'idx_animal_arrival_animal', fields: ['animal'])]
#[ORM\HasLifecycleCallbacks]
class AdoptionRequest
{
    use TimestampableTrait;
    use BlameableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'adoptionRequests')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $requester = null;

    #[ORM\ManyToOne(inversedBy: 'adoptionRequests')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Animal $animal = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $details = null;

    #[ORM\OneToOne(mappedBy: 'adoptionRequest', cascade: ['persist', 'remove'])]
    private ?AnimalAdoption $animalAdoption = null;

    /**
     * @var Collection<int, Document>
     */
    #[ORM\OneToMany(targetEntity: Document::class, mappedBy: 'adoptionRequest', orphanRemoval: true)]
    private Collection $documents;

    public function __construct()
    {
        $this->documents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRequester(): ?User
    {
        return $this->requester;
    }

    public function setRequester(?User $requester): static
    {
        $this->requester = $requester;

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

    public function getDetails(): ?string
    {
        return $this->details;
    }

    public function setDetails(string $details): static
    {
        $this->details = $details;

        return $this;
    }

    public function getAnimalAdoption(): ?AnimalAdoption
    {
        return $this->animalAdoption;
    }

    public function setAnimalAdoption(?AnimalAdoption $animalAdoption): static
    {
        // unset the owning side of the relation if necessary
        if ($animalAdoption === null && $this->animalAdoption !== null) {
            $this->animalAdoption->setAdoptionRequest(null);
        }

        // set the owning side of the relation if necessary
        if ($animalAdoption !== null && $animalAdoption->getAdoptionRequest() !== $this) {
            $animalAdoption->setAdoptionRequest($this);
        }

        $this->animalAdoption = $animalAdoption;

        return $this;
    }

    /**
     * @return Collection<int, Document>
     */
    public function getDocuments(): Collection
    {
        return $this->documents;
    }

    public function addDocument(Document $document): static
    {
        if (!$this->documents->contains($document)) {
            $this->documents->add($document);
            $document->setAdoptionRequest($this);
        }

        return $this;
    }

    public function removeDocument(Document $document): static
    {
        if ($this->documents->removeElement($document)) {
            // set the owning side to null (unless already changed)
            if ($document->getAdoptionRequest() === $this) {
                $document->setAdoptionRequest(null);
            }
        }

        return $this;
    }
}
