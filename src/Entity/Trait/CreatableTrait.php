<?php

namespace App\Entity\Trait;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Warning : add #[HasLifecycleCallbacks] annotation for each entity implementing this trait
 */
trait CreatableTrait
{
    #[ORM\Column]
    #[Assert\DateTime]
    #[Assert\NotBlank]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull]
    #[Assert\Valid]
    #[Assert\Type(User::class)]
    private ?User $createdBy = null;

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?User $createdBy): static
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    #[ORM\PrePersist]
    public function setCreatedAtValue(): void
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->setUpdatedAtValue();
    }

    #[ORM\PrePersist]
    public function setCreatedByValue(Security $security): void
    {
        if (!$this->createdBy) {
            $user = $security->getUser();
            if ($user instanceof User) {
                $this->createdBy = $user;
            }
        }
    }
}