<?php

namespace App\Entity\Trait;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bundle\SecurityBundle\Security;

/**
 * Warning : add #[HasLifecycleCallbacks] annotation for each entity implementing this trait
 */
trait BlameableTrait
{
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $created_by = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    private ?User $updated_by = null;

    public function getCreatedBy(): ?User
    {
        return $this->created_by;
    }

    public function setCreatedBy(?User $created_by): static
    {
        $this->created_by = $created_by;

        return $this;
    }

    public function getUpdatedBy(): ?User
    {
        return $this->updated_by;
    }

    public function setUpdatedBy(?User $updated_by): static
    {
        $this->updated_by = $updated_by;
        return $this;
    }

    #[ORM\PrePersist]
    public function setCreatedByValue(Security $security): void
    {
        if (!$this->created_by) {
            $user = $security->getUser();
            if ($user instanceof User) {
                $this->created_by = $user;
            }
        }
    }

    #[ORM\PreUpdate]
    public function setUpdatedByValue(Security $security): void
    {
        $user = $security->getUser();
        if ($user instanceof User) {
            $this->updated_by = $user;
        }
    }
}