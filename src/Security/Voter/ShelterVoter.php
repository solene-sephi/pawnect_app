<?php

namespace App\Security\Voter;

use App\Entity\User;
use App\Entity\Shelter;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;

final class ShelterVoter extends Voter
{
    public const EDIT_PARTIALLY = 'edit_partially';

    public function __construct(
        private AccessDecisionManagerInterface $accessDecisionManager,
    ) {
    }

    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, [self::EDIT_PARTIALLY])
            && $subject instanceof Shelter;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        /** @var Shelter $shelter */
        $shelter = $subject;

        // If the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // Grant all access
        if ($this->accessDecisionManager->decide($token, ['ROLE_ADMIN'])) {
            return true;
        }

        return match ($attribute) {
            self::EDIT_PARTIALLY => $this->canEditPartially($shelter, $user, $token),
            default => throw new \LogicException('This code should not be reached!')
        };
    }
    private function canEditPartially(Shelter $shelter, User $user, TokenInterface $token): bool
    {
        if ($this->accessDecisionManager->decide($token, ['ROLE_SHELTER_ADMIN'])) {
            return true;
        }

        return false;
    }
}
