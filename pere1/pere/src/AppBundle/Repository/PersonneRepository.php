<?php
/**
 * Created by PhpStorm.
 * User: Matt
 * Date: 11/02/2016
 * Time: 10:50
 */

namespace AppBundle\Repository;


use AppBundle\Entity\Personne;
use Doctrine\ORM\EntityRepository;
use Exception;

class PersonneRepository extends EntityRepository
{

    public function findAll() {
        return $this->createQueryBuilder('a')
            ->getQuery()
            ->getResult();
    }
    public function findAllActive() {
        return $this->createQueryBuilder('a')
            ->getQuery()
            ->getResult();
    }

    public function findOneByPersonneId(Personne $personne) {  // On passe par le QueryBuilder vide de l'EntityManager pour l'exemple
        $qb = $this->createQueryBuilder("p");
        $qb->select('a')
            ->from('AppBundle:Personne', 'a')
            ->where('a.personneId = :id')
            ->setParameter('id', $personne->getPersonneId());

        return $qb->getQuery()
            ->setMaxResults(1)->getOneOrNullResult();
    }

    public function findByEmail($email) {
      // On passe par le QueryBuilder vide de l'EntityManager pour l'exemple
        $qb = $this->_em->createQueryBuilder();
        $qb->select('a')
            ->from('AppBundle:Personne', 'a')
            ->where('a.email= :email')
            ->setParameter('email', $email);

        return $qb->getQuery()
            ->setMaxResults(1)->getOneOrNullResult();
    }

    public function addPersonne(Personne $pers ){
        $em = $this->getEntityManager();
        $p= $this->find($pers->getPersonneId());

        if ($p) {
            throw new Exception(
                'this compte already exists '
            );
        }
        $em->persist($pers);
        $em->flush();
    }
}