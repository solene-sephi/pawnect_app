<?php

namespace App\Service;

use App\Entity\User;
use App\Entity\Shelter;
use Symfony\Bundle\SecurityBundle\Security;

class ShelterService
{
    public function __construct(
        private Security $security,
    ) {
    }

    public function getShelterForLoggedUser(): ?Shelter
    {
        $user = $this->security->getUser();

        if ($user instanceof User) {
            return $user->getShelterEmployee()->getShelter();
        }
        return null;
    }
}