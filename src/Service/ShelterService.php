<?php

namespace App\Service;

use App\Entity\User;
use App\Entity\Shelter;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class ShelterService
{
    public function __construct(
        private Security $security,
    ) {
    }

    public function getShelterForLoggedUser(): ?Shelter
    {
        $user = $this->security->getUser();

        if (!$user instanceof UserInterface) {
            return null;
        }

        /** @var User $user */
        return $user->getShelterEmployee()->getShelter() ?? null;
    }

    public function hasAssociatedShelter(): bool
    {
        return $this->getShelterForLoggedUser() !== null ? true : false;
    }

    public function isShelterUser(): bool
    {
        return $this->security->isGranted(attributes: 'ROLE_SHELTER_EMPLOYEE')
            || $this->security->isGranted('ROLE_SHELTER_ADMIN');
    }
}