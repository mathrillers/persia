<?php
/**
 * Created by PhpStorm.
 * User: Matt
 * Date: 12/02/2016
 * Time: 16:43
 */

namespace AppBundle\Repository;


use AppBundle\Entity\Annonce;
use AppBundle\Entity\Personne;
use Doctrine\ORM\EntityRepository;

class PostulerRepository extends EntityRepository
{
    public function findOneByAnnonceJoinedToPersonne(Annonce $annonce,Personne $personne)
    {
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT p FROM AppBundle:Postuler p
                      WHERE p.personne = :pers AND p.annonce=:annonce'
            )->setParameter('pers', $personne)
            ->setParameter('annonce', $annonce);

        try {
            return $query->getSingleResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }
}