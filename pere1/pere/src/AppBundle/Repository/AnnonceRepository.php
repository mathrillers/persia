<?php
/**
 * Created by PhpStorm.
 * User: Matt
 * Date: 12/02/2016
 * Time: 17:20
 */

namespace AppBundle\Repository;


use Doctrine\ORM\EntityRepository;

class AnnonceRepository extends EntityRepository
{


    public function research($mot,$ville,$typeimo,$acte,$minpx,$maxpx){

        $qry='SELECT a,i,q,t FROM AppBundle:Annonce a JOIN a.immobilier i JOIN i.quartier q JOIN i.idType t WHERE';
        if($mot){
            $qry=$qry.' a.titre like :mot AND';
        }
        if($ville){
            $qry=$qry.' q.ville = :ville AND';
        }
        if($typeimo){
            $qry=$qry.' t.nom like :typeimo AND';
        }
        if($acte){
            $qry=$qry.' a.typeAnnonce like :acte AND';
        }
        if($acte=="Location") {
            $qry = $qry . ' a.prixDelai between :minpx and :maxpx';
        }
        if($acte=="Vente") {
            $qry = $qry . ' a.montant between :minpx and :maxpx';
        }
        $query =$this->_em->createQuery($qry
        )->setParameter('minpx',$minpx)
            ->setParameter('maxpx',$maxpx);

        if($mot){
            $query->setParameter('mot', '%'.$mot.'%');
        }
        if($ville){
            $query->setParameter('ville',$ville);
        }
        if($typeimo){
            $query->setParameter('typeimo','%'.$typeimo.'%');
        }
        if($acte){
            $query->setParameter('acte','%'.$acte.'%');
        }

        return $query->getResult();
    }


    public function researchAffaire($besoin,$ville,$type){

        $qry='SELECT a,i,q,t FROM AppBundle:Annonce a JOIN a.immobilier i JOIN i.quartier q JOIN i.idType t WHERE';

        if($ville){
            $qry=$qry.' q.ville = :ville AND';
        }
        if($type){
            $qry=$qry.' t.nom like :type AND';
        }
        if($besoin){
            $qry=$qry.' a.typeAnnonce like :besoin ';
        }

        $query =$this->_em->createQuery($qry );


        if($ville){
            $query->setParameter('ville',$ville);
        }
        if($type){
            $query->setParameter('type','%'.$type.'%');
        }
        if($besoin){
            $query->setParameter('besoin','%'.$besoin.'%');
        }

        return $query->getResult();
    }

    public function annonceCategorie($ville,$acte){

        $qb=$this->_em->createQueryBuilder();
        $qb->select('a','i','q')
            ->from('AppBundle:Annonce','a')
            ->innerJoin('a.immobilier','i')
            ->innerJoin('i.quartier','q')
            ->where('q.ville = :ville')
            ->setParameter('ville',$ville)
            ->andWhere('a.typeAnnonce = :acte')
            ->setParameter('acte',$acte);

        return $qb->getQuery()->getResult();
    }


    public function newsletter(){

        $qb=$this->_em->createQueryBuilder();
        $qb->select('a')
            ->from('AppBundle:Annonce','a')
            ->orderBy('a.annonceId', 'DESC');

        return $qb->getQuery()->getResult();
    }

    public function newslettertop(){

        $qb=$this->_em->createQueryBuilder();
        $qb->select('a')
            ->from('AppBundle:Annonce','a')
            ->orderBy('a.annonceId', 'DESC')
            ->setMaxResults( 2 );

        return $qb->getQuery()->getResult();
    }


    public function typeimmobilier($typeimo){

        $qb=$this->_em->createQueryBuilder();
        $qb->select('a','i','t')
            ->from('AppBundle:Annonce','a')
            ->innerJoin('a.immobilier','i')
            ->innerJoin('i.idType','t')
            ->where('t.nom like :typeimo')
            ->setParameter('typeimo','%'.$typeimo.'%');

        return $qb->getQuery()->getResult();
    }



    public function findMaxVente(){
        $qb=$this->_em->createQueryBuilder();
        $qb->select('MAX(a.montant) as maxs')
            ->from('AppBundle:Annonce','a')
            ->where('a.typeAnnonce = :type')
            ->setParameter('type', 'Vente')
            ->setMaxResults( 1 );

        return $qb->getQuery()->getOneOrNullResult()['maxs'];
    }
    public function findMinVente(){

        $qb=$this->_em->createQueryBuilder();
        $qb->select('MIN(a.montant) as mins')
            ->from('AppBundle:Annonce','a')
            ->where('a.typeAnnonce= :type')
            ->setParameter('type', 'Vente')
            ->setMaxResults( 1 );

        return $qb->getQuery()->getOneOrNullResult()['mins'];
    }
    public function findMaxLoc(){
        $qb=$this->_em->createQueryBuilder();
        $qb->select('MAX(a.prixDelai) as maxs')
            ->from('AppBundle:Annonce','a')
            ->where('a.typeAnnonce= :type')
            ->setParameter('type', 'Location')
            ->setMaxResults( 1 );

        return $qb->getQuery()->getOneOrNullResult()['maxs'];
    }
    public function findMinLoc(){
        $qb=$this->_em->createQueryBuilder();
        $qb->select('MIN(a.prixDelai) as mins')
            ->from('AppBundle:Annonce','a')
            ->where('a.typeAnnonce= :type')
            ->setParameter('type', 'Location')
            ->setMaxResults( 1 );

        return $qb->getQuery()->getOneOrNullResult()['mins'];
    }
}