<?php
/**
 * Created by PhpStorm.
 * User: Matt
 * Date: 04/02/2016
 * Time: 16:11
 */

namespace AppBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Exception;

class TypeImmobilierRepository extends EntityRepository
{
    public function findByName($name){
        return $this->findOneBy(
            array('nom'=>$name)
        );
    }


    public function findById($idType){
        return $this->find($idType);
    }


    public function addTypeImmobilier($typeimmobilier ){
        $em = $this->getEntityManager();
        $type= $this->find($typeimmobilier->getIdType());

        if ($type) {
            throw new Exception(
                'this type immobilier already exists '
            );
        }
        $em->persist($typeimmobilier);
        $em->flush();
    }
    public function updateTypeImmobilier($typeimmobilier)
    {
        $em = $this->getEntityManager();
        $type= $this->find($typeimmobilier->getIdType());

        if (!$type) {
            throw new Exception(
                'No type immobilier found '
            );
        }
        /*PAS NECESSAIRE*/
        $em->persist($typeimmobilier);

        $em->flush();


    }

    public function removeTypeImmobilier($idType)
    {
        $em = $this->getEntityManager();
        $type= $this->find($idType);

        if (!$type) {
            throw new Exception(
                'No type immobilier found '
            );
        }

        $em->remove($type);
        $em->flush();


    }

}