<?php
/**
 * Created by PhpStorm.
 * User: Matt
 * Date: 18/04/2016
 * Time: 11:12
 */

namespace AppBundle\Security;


use AppBundle\Entity\Annonce;
use AppBundle\Entity\Compte;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class AnnonceVoter extends Voter
{
    // these strings are just invented: you can use anything
    const VIEW = 'view';
    const EDIT = 'edit';
    const DELETE = 'delete';


    private $decisionManager;

    public function __construct(AccessDecisionManagerInterface $decisionManager)
    {
        $this->decisionManager = $decisionManager;
    }

    protected function supports($attribute, $subject)
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, array(self::VIEW, self::EDIT, self::DELETE))) {
            return false;
        }

        // only vote on Post objects inside this voter
        if (!$subject instanceof Annonce) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof Compte) {
            // the user must be logged in; if not, deny access
            return false;
        }
        if ($this->decisionManager->decide($token, array('ROLE_SUPER_ADMIN'))) {
            return true;
        }
        if ($this->decisionManager->decide($token, array('ROLE_ADMIN'))) {
            return true;
        }
        // you know $subject is a Post object, thanks to supports
        /** @var Annonce $annonce */
        $annonce = $subject;

        switch($attribute) {
            case self::VIEW:
                return $this->canView($annonce, $user);
            case self::EDIT:
                return $this->canEdit($annonce, $user);
            case self::DELETE:
                return $this->canDelete($annonce, $user);

        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canView(Annonce $annonce, Compte $user)
    {
        // if they can edit, they can view
        if ($this->canEdit($annonce, $user)) {
            return true;
        }

        // the Post object could have, for example, a method isPrivate()
        // that checks a boolean $private property

      //  return !$annonce->isPrivate();
        return true;
    }

    private function canEdit(Annonce $annonce, Compte $user)
    {
        // this assumes that the data object has a getOwner() method
        // to get the entity of the user who owns this data object
        return $user->getPersonne() === $annonce->getDepositaire();
    }

    private function canDelete(Annonce $annonce, Compte $user)
    {
        // this assumes that the data object has a getOwner() method
        // to get the entity of the user who owns this data object
        return $user->getPersonne() === $annonce->getDepositaire();
    }
}