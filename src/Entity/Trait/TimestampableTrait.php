<?php

namespace App\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Warning : add #[HasLifecycleCallbacks] annotation for each entity implementing this trait
 */
trait TimestampableTrait
{
    #[ORM\Column]
    // These fields are managed automatically by Doctrine via the PrePersist lifecycle event.
    // Adding a DateTime constraint would interfere with the automatic handling of these fields.
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    // These fields are managed automatically by Doctrine via the PreUpdate lifecycle event.
    // Adding a DateTime constraint would interfere with the automatic handling of these fields.
    private ?\DateTimeImmutable $updatedAt = null;


    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    #[ORM\PrePersist]
    public function setCreatedAtValue(): void
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->setUpdatedAtValue();
    }

    #[ORM\PreUpdate]
    public function setUpdatedAtValue(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
    }
}