<?php

namespace App\Entity;

use App\Entity\Enum\GeneralStatusEnum;
use App\Entity\Trait\BlameableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Trait\TimestampableTrait;
use App\Repository\ShelterApprovalRepository;

#[ORM\Entity(repositoryClass: ShelterApprovalRepository::class)]
#[ORM\Table(name: '`shelter_approval`')]
#[ORM\HasLifecycleCallbacks]
#[ORM\Index(name: "idx_shelter_approvals_shelter_id", fields: ["id"])]
class ShelterApproval
{
    use TimestampableTrait;
    use BlameableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'shelterApproval', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Shelter $shelter = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $comment = null;

    /**
     * @var Collection<int, Document>
     */
    #[ORM\OneToMany(targetEntity: Document::class, mappedBy: 'shelterApproval', orphanRemoval: true)]
    private Collection $documents;

    #[ORM\Column(enumType: GeneralStatusEnum::class)]
    private ?GeneralStatusEnum $status = null;

    public function __construct()
    {
        $this->documents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getShelter(): ?Shelter
    {
        return $this->shelter;
    }

    public function setShelter(Shelter $shelter): static
    {
        $this->shelter = $shelter;

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
            $document->setShelterApproval($this);
        }

        return $this;
    }

    public function removeDocument(Document $document): static
    {
        if ($this->documents->removeElement($document)) {
            // set the owning side to null (unless already changed)
            if ($document->getShelterApproval() === $this) {
                $document->setShelterApproval(null);
            }
        }

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
