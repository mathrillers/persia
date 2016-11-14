<?php
/**
 * Created by PhpStorm.
 * User: Matt
 * Date: 23/03/2016
 * Time: 15:51
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * Notification
 *
 * @ORM\Table(name="notification")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\NotificationRepository")
 */
class Notification
{
    /**
     * @var integer
     *
     * @ORM\Column(name="notification_ID", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */

    private  $notificationId;

    /**
     * @var int
     *
     * @ORM\Column(name="id_entity", type="integer")
     */

    private  $idEntity;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_notification", type="datetime", nullable=true)
     */
    private $dateNotification;


    /**
     * @var \AppBundle\Entity\Compte
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Compte")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="compte_ID", referencedColumnName="compte_ID")
     * })
     */
    private $compte;


    /**
     * Notification constructor.
     */
    public function __construct()
    {

    }




    /**
     * @return int
     */
    public function getNotificationId()
    {
        return $this->notificationId;
    }




    /**
     * @return \DateTime
     */
    public function getDateNotification()
    {
        return $this->dateNotification;
    }

    /**
     * @param \DateTime $dateNotification
     */
    public function setDateNotification($dateNotification)
    {
        $this->dateNotification = $dateNotification;
    }


    /**
     * @return Compte
     */
    public function getCompte()
    {
        return $this->compte;
    }

    /**
     * @param Compte $compte
     */
    public function setCompte($compte)
    {
        $this->compte = $compte;
    }

    /**
     * @return int
     */
    public function getIdEntity()
    {
        return $this->idEntity;
    }

    /**
     * @param int $identity
     */
    public function setIdEntity($idEntity)
    {
        $this->idEntity = $idEntity;
    }




}