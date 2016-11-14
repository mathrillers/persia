<?php
/**
 * Created by PhpStorm.
 * User: Matt
 * Date: 04/02/2016
 * Time: 12:09
 */

namespace AppBundle\Repository;


use AppBundle\Entity\Role;
use Doctrine\ORM\EntityRepository;
use Exception;

class RoleRepository extends EntityRepository
{

    public function findAllRole(){
        return $this->findAll();
    }
    public function findByName( $name){
        return $this->findOneBy(
            array('roleNom'=>$name)
        );
    }

    public function addRole(Role $role ){
        $em = $this->getEntityManager();
        $r= $this->find($role->getRoleId());

        if ($r) {
            throw new Exception(
                'this role already exists '
            );
        }
        $em->persist($role);
        $em->flush();
    }
    public function updateRole(Role $role)
    {
        $em = $this->getEntityManager();
        $r= $this->find($role->getRoleId());

        if (!$r) {
            throw new Exception(
                'No role found '
            );
        }

        $em->persist($role);
        $em->flush();


    }

   public function removeRole($roleId)
    {
        $em = $this->getEntityManager();
        $r= $this->find($roleId);

        if (!$r) {
            throw new Exception(
                'No role found '
            );
        }

        $em->remove($r);
        $em->flush();


    }


}