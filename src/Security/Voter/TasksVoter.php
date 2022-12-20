<?php

namespace App\Security\Voter;

use App\Entity\Task;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class TasksVoter extends Voter
{
    public const EDIT = 'POST_EDIT';
    public const VIEW = 'POST_VIEW';

    protected function supports(string $attribute, $task): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::EDIT, self::VIEW])
            && $task instanceof \App\Entity\Task;
    }

    protected function voteOnAttribute(string $attribute, $task, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }
        //on verifie si l'utilisateur est nulle.
        if(null === $task->getUser()) return false;

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::EDIT:
                // logic to determine if the user can EDIT
                // return true or false
                return $this->canEdit($task,$user);
                break;
            case self::VIEW:
                // logic to determine if the user can VIEW
                // return true or false
                return $this->canView($task, $user);
                break;
        }

        return false;
    }
    private function canEdit(Task $task, User $user ){
        return $user === $task->getUser();
        $user->getRoles(['ROLE_ADMIN']);
    }
    private function canView(Task $task, User $user){
        return $user === $task->getUser();
        $user->getRoles(['ROLE_ADMIN']);
        
    }
}
