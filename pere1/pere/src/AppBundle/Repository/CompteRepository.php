<?php
/**
 * Created by PhpStorm.
 * User: Matt
 * Date: 02/02/2016
 * Time: 14:44
 */

namespace AppBundle\Repository;


use AppBundle\Entity\Compte;
use Doctrine\ORM\EntityRepository;
use Exception;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

class CompteRepository extends EntityRepository implements UserLoaderInterface
{
/*    public function loadUserByUsername($username)
{
    $user = $this->_em->createQueryBuilder()
        ->select('a')
        ->from('AppBundle:Compte', 'a')
        ->where('u.username= :username')
        ->andWhere( 'a.active =true')
        ->setParameter('username', $username)
        ->getQuery()
        ->getOneOrNullResult();

    if (null === $user) {
        $message = sprintf(
            'Unable to find an active admin AppBundle:Compte object identified by "%s".',
            $username
        );
        throw new UsernameNotFoundException($message);
    }

    return $user;
}*/

   public function loadUserByUsername($username)
    {
        return $this->createQueryBuilder('u')
            ->where('u.username = :username  AND u.active = true')
            ->setParameter('username', $username)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findAllActive() {  // On passe par le QueryBuilder vide de l'EntityManager pour l'exemple
        $qb = $this->_em->createQueryBuilder();
        $qb->select('a')
            ->from('AppBundle:Compte', 'a')
            ->where('a.active =true');

        return $qb->getQuery()
            ->getResult(); }
    public function activeAccount($active) {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('a')
            ->from('AppBundle:Compte', 'a')
            ->where('a.active = :active')
            ->setParameter('active', $active);

        return $qb->getQuery()->getResult();
    }
    public function findAll() {
        return $this->createQueryBuilder('a')
            ->getQuery()
            ->getResult();
    }

    public function findOne($id) {  // On passe par le QueryBuilder vide de l'EntityManager pour l'exemple
     $qb = $this->_em->createQueryBuilder();
        $qb->select('a')
            ->from('AppBundle:Compte', 'a')
            ->where('a.compteId = :id')
            ->setParameter('id', $id);

        return $qb->getQuery()
                ->getResult(); }

    public function findByLogin($login) {  // On passe par le QueryBuilder vide de l'EntityManager pour l'exemple
        $qb = $this->_em->createQueryBuilder();
        $qb->select('a')
            ->from('AppBundle:Compte', 'a')
            ->where('a.username = :login')
            ->setParameter('login', $login);

        return $qb->getQuery()
            ->setMaxResults(1)->getOneOrNullResult();
    }

    public function addCompte(Compte $compte ){
        $em = $this->getEntityManager();
        $c= $this->find($compte->getCompteId());

        if ($c) {
            throw new Exception(
                'this compte already exists '
            );
        }
        $em->persist($compte);
        $em->flush();
    }
}
