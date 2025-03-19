<?php

namespace App\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

trait SoftDeletableTrait
{

    #[ORM\Column(nullable: true)]
    #[Assert\DateTime]
    private ?\DateTimeImmutable $deleted_at = null;


    public function getDeletedAt(): ?\DateTimeImmutable
    {
        return $this->deleted_at;
    }

    public function setDeletedAt(?\DateTimeImmutable $deleted_at): static
    {
        $this->deleted_at = $deleted_at;

        return $this;
    }

    public function isDeleted(): bool
    {
        return $this->deletedAt !== null;
    }
}