<?php

namespace App\Security\Voter;

use App\Entity\Task;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Security;

class TasksVoter extends Voter
{
    public const EDIT = 'TASK_EDIT';
    public const VIEW = 'TASK_VIEW';

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports(string $attribute, $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
       
        return in_array($attribute, [self::EDIT, self::VIEW])
            && $subject instanceof \App\Entity\Task;

    }


    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }
        //on vérifie si l'utilisateur est admin

       // if ($this->security->isGranted("ROLE_ADMIN")) return true; 
        //on verifie si l'utilisateur est nulle.
        if(null === $subject->getUser()) return false;

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::EDIT:
                // logic to determine if the user can EDIT
                // return true or false
                return $this->canEdit($subject,$user);
                break;
            case self::VIEW:
                // logic to determine if the user can VIEW
                // return true or false
                return $this->canView($subject, $user);
                break;
        }

        return false;
    }
    private function canEdit(Task $task, User $user ){

        
            return $user === $task->getUser();
        
    }
    private function canView(Task $task, User $user){
        return $user === $task->getUser();
    
        
        
    }
}
