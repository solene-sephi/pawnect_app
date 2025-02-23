<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Enum\DocumentEnum;
use App\Entity\Trait\CreatableTrait;
use App\Repository\DocumentRepository;

#[ORM\Entity(repositoryClass: DocumentRepository::class)]
#[ORM\Table(name: '`document`')]
#[ORM\HasLifecycleCallbacks]
#[ORM\Index(name: 'idx_document_created_by', fields: ['createdBy'])]
#[ORM\Index(name: 'idx_document_document_type', fields: ['documentType'])]
#[ORM\Index(name: 'idx_document__created_at', fields: ['createdAt'])]
class Document
{
    use CreatableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $filename = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $filepath = null;

    #[ORM\Column(enumType: DocumentEnum::class)]
    private ?DocumentEnum $documentType = null;

    #[ORM\ManyToOne(inversedBy: 'documents')]
    private ?ShelterApproval $shelterApproval = null;

    // #[ORM\ManyToOne(inversedBy: 'documents')]
    // private ?AdoptionRequest $adoptionRequest = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getFilepath(): ?string
    {
        return $this->filepath;
    }

    public function setFilepath(string $filepath): static
    {
        $this->filepath = $filepath;

        return $this;
    }

    public function getDocumentType(): ?DocumentEnum
    {
        return $this->documentType;
    }

    public function setDocumentType(DocumentEnum $documentType): static
    {
        $this->documentType = $documentType;

        return $this;
    }

    public function getShelterApproval(): ?ShelterApproval
    {
        return $this->shelterApproval;
    }

    public function setShelterApproval(?ShelterApproval $shelterApproval): static
    {
        $this->shelterApproval = $shelterApproval;

        return $this;
    }

    public function getAdoptionRequest(): ?AdoptionRequest
    {
        return $this->adoptionRequest;
    }

    public function setAdoptionRequest(?AdoptionRequest $adoptionRequest): static
    {
        $this->adoptionRequest = $adoptionRequest;

        return $this;
    }
}
