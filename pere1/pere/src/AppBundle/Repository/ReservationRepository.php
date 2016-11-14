<?php
/**
 * Created by PhpStorm.
 * User: Matt
 * Date: 04/02/2016
 * Time: 11:48
 */

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Exception;

class ReservationRepository extends EntityRepository
{


    public function findById($ReservationId){
        return $this->find($ReservationId);
    }

    public function findAllByMontant($montant1, $montant2){
        $em = $this->getEntityManager();
        $query = $em->createQuery(
            'SELECT r
    FROM AppBundle:Reservation r
    WHERE r.montant BETWEEN :montant1 AND :montant2
    ORDER BY r.montant ASC'
        ) ->setParameter('montant1', $montant1)
            ->setParameter('montant2', $montant2);

       return $query->getResult();

    }


    public function findAllByDate($date1, $date2){
        $em = $this->getEntityManager();
        $query = $em->createQuery(
            'SELECT r
    FROM AppBundle:Reservation r
    WHERE r.dateReservation BETWEEN :date1 AND :date2
    ORDER BY r.montant ASC'
        ) ->setParameter('date1', $date1)
            ->setParameter('date2', $date2);

        return $query->getResult();

    }

    public function addReservation($reservation ){
        $em = $this->getEntityManager();
        $reserv= $this->find($reservation->getReservationId());

        if (!$reserv) {
            throw new Exception(
                'this Reservation already exists '
            );
        }
        $em->persist($reservation);
        $em->flush();
    }
    public function update($reservation)
    {
        $em = $this->getEntityManager();
        $reserv= $this->find($reservation->getReservationId());

        if (!$reserv) {
            throw new Exception(
                'No Reservation found '
            );
        }

        $em->persist($reservation);
        $em->flush();


    }

    public function remove($reservationId)
    {
        $em = $this->getEntityManager();
        $reserv= $this->find($reservationId);

        if (!$reserv) {
            throw new Exception(
                'No Reservation found '
            );
        }

        $em->remove($reserv);
        $em->flush();


    }

}