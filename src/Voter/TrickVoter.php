<?php

namespace App\Voter;

use App\Entity\Trick;
use App\Entity\Utilisateur;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class TrickVoter extends Voter
{
    const EDIT = 'edit';

    protected function supports(string $attribute, mixed $subject): bool
    {
        // only vote on `Post` objects
        if (!$subject instanceof Trick) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $currentUser = $token->getUser();

        if (!$currentUser instanceof Utilisateur) {
            return false;
        }

        return match ($attribute) {
            self::EDIT => $this->canEdit($subject, $currentUser),
            default => throw new \LogicException('This code should not be reached!')
        };
    }

    private function canEdit(Trick $subject, Utilisateur $currentUser): bool
    {
        
        if ($subject->getAuteur() == $currentUser) {
            return true;
        }

        if (in_array('ROLE_ADMIN', $currentUser->getRoles())) {
            return true;
        }

        return false;
    }
}