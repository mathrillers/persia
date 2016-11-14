<?php
/**
 * Created by PhpStorm.
 * User: Matt
 * Date: 08/03/2016
 * Time: 11:59
 */

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * Paiement
 *
 * @ORM\Table(name="paiement")
 * @ORM\Entity
 */
class Paiement
{

    /**
     * @var integer
     *
     * @ORM\Column(name="paiement_ID", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $paiementId;


    /**
     * @var \AppBundle\Entity\Reservation
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Reservation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="reservation_ID", referencedColumnName="reservation_ID")
     * })
     */
    private $reservation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_paiement", type="datetime", nullable=true)
     */
    private $datePaiement;

    /**
     * @var float
     *
     * @ORM\Column(name="montant", type="float", precision=10, scale=0, nullable=true)
     */
    private $montant;

    /**
     * @var string
     *
     * @ORM\Column(name="mode_paiement", type="string", length=254, nullable=true)
     */
    private $modePaiement;

    /**
     * @return int
     */
    public function getPaiementId()
    {
        return $this->paiementId;
    }

    /**
     * @param int $paiementId
     */
    public function setPaiementId($paiementId)
    {
        $this->paiementId = $paiementId;
    }

    /**
     * @return Reservation
     */
    public function getReservation()
    {
        return $this->reservation;
    }

    /**
     * @param Reservation $reservation
     */
    public function setReservation($reservation)
    {
        $this->reservation = $reservation;
    }

    /**
     * @return \DateTime
     */
    public function getDatePaiement()
    {
        return $this->datePaiement;
    }

    /**
     * @param \DateTime $datePaiement
     */
    public function setDatePaiement($datePaiement)
    {
        $this->datePaiement = $datePaiement;
    }

    /**
     * @return float
     */
    public function getMontant()
    {
        return $this->montant;
    }

    /**
     * @param float $montant
     */
    public function setMontant($montant)
    {
        $this->montant = $montant;
    }

    /**
     * @return string
     */
    public function getModePaiement()
    {
        return $this->modePaiement;
    }

    /**
     * @param string $modePaiement
     */
    public function setModePaiement($modePaiement)
    {
        $this->modePaiement = $modePaiement;
    }


}