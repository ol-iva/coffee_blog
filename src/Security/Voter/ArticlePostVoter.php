<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class ArticlePostVoter extends Voter
{
    protected function supports($attribute, $subject)
    {
        return in_array($attribute, ['true', 'false']);
//            && $subject instanceof \App\Entity\Article;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        if ($attribute == true) {
            return true;
        }

//        // ... (check conditions and return true to grant permission) ...
//        switch ($attribute) {
//            case 'POST_EDIT':
//                // logic to determine if the user can EDIT
//                // return true or false
//                break;
//            case 'POST_VIEW':
//                // logic to determine if the user can VIEW
//                // return true or false
//                break;

        return false;
    }
}