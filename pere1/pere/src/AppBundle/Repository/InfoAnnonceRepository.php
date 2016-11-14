<?php
/**
 * Created by PhpStorm.
 * User: Matt
 * Date: 16/02/2016
 * Time: 14:19
 */

namespace AppBundle\Repository;


use AppBundle\Entity\Personne;
use Doctrine\ORM\EntityRepository;

class InfoAnnonceRepository extends EntityRepository
{

    public function findByAllFavoris(){

        $qb = $this->createQueryBuilder('p');
        $qb->select('a')
            ->from('AppBundle:InfoAnnonce', 'a')
            ->where('a.favori=true');

        return $qb->getQuery()
            ->getResult();

    }
    public function allFavorisPers(Personne $pers){

        $qb = $this->_em->createQueryBuilder();
        $qb->select('a')
            ->from('AppBundle:InfoAnnonce', 'a')
            ->where('a.favori=true')
            ->andWhere('a.personneid = :idPers')
            ->setParameter('idPers',$pers->getPersonneId());

        return $qb->getQuery()
            ->getResult();

    }

    public function findByAllJaime(){

        $qb = $this->createQueryBuilder('');
        $qb->select('a')
            ->from('AppBundle:InfoAnnonce', 'a')
            ->where('a.aime=true');

        return $qb->getQuery()
            ->getResult();

    }
    public function allJaimePers(Personne $pers){

        $qb = $this->_em->createQueryBuilder();
        $qb->select('a')
            ->from('AppBundle:InfoAnnonce', 'a')
            ->where('a.aime=true')
            ->andWhere('a.personneid = :idPers')
            ->setParameter('idPers',$pers->getPersonneId());

        return $qb->getQuery()
            ->getResult();

    }
}