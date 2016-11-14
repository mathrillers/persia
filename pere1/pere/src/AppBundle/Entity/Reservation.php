<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reservation
 *
 * @ORM\Table(name="reservation")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ReservationRepository")
 */
class Reservation
{


    /**
     * @var \AppBundle\Entity\Postuler
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Postuler", inversedBy="reservation")
     * @ORM\JoinColumn(name="post_ID", referencedColumnName="post_ID")
     */
    private $postuler;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_reservation", type="datetime", nullable=true)
     */
    private $dateReservation;

    /**
     * @var float
     *
     * @ORM\Column(name="montant", type="float", precision=10, scale=0, nullable=true)
     */
    private $montant;


    /**
     * @var integer
     *
     * @ORM\Column(name="reservation_ID", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $reservationId;




    /**
     * @return \AppBundle\Entity\Postuler
     */
    public function getPostuler()
    {
        return $this->postuler;
    }

    /**
     * @param \AppBundle\Entity\Postuler $postuler
     */
    public function setPostuler($postuler)
    {
        $this->postuler = $postuler;
    }



    /**
     * Set dateReservation
     *
     * @param \DateTime $dateReservation
     *
     * @return Reservation
     */
    public function setDateReservation($dateReservation)
    {
        $this->dateReservation = $dateReservation;

        return $this;
    }

    /**
     * Get dateReservation
     *
     * @return \DateTime
     */
    public function getDateReservation()
    {
        return $this->dateReservation;
    }

    /**
     * Set montant
     *
     * @param float $montant
     *
     * @return Reservation
     */
    public function setMontant($montant)
    {
        $this->montant = $montant;

        return $this;
    }

    /**
     * Get montant
     *
     * @return float
     */
    public function getMontant()
    {
        return $this->montant;
    }

    /**
     * Get reservationId
     *
     * @return integer
     */
    public function getReservationId()
    {
        return $this->reservationId;
    }
}
