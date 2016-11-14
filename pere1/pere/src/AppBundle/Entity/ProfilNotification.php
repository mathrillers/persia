<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProfilNotification
 *
 * @ORM\Table(name="profil_notification", indexes={@ORM\Index(name="compte_ID", columns={"compte_ID"}), @ORM\Index(name="FK_profil_not", columns={"notification_ID"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProfilNotificationRepository")
 */
class ProfilNotification
{
    /**
     * @var integer
     *
     * @ORM\Column(name="profil_notif_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $profilNotifId;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean", nullable=false)
     */
    private $active;


    /**
     * @var \AppBundle\Entity\Compte
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Compte",cascade={"persist","remove"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="compte_ID", referencedColumnName="compte_ID")
     * })
     */
    private $compte;

    /**
     * @var \AppBundle\Entity\Notification
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Notification")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="notification_ID", referencedColumnName="notification_ID")
     * })
     */
    private $notification;

    /**
     * @var \AppBundle\Entity\TypeNotification
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TypeNotification")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="type_notif_ID", referencedColumnName="type_notif_ID")
     * })
     */
    private $typeNotification;

    /**
     * @return int
     */
    public function getProfilNotifId()
    {
        return $this->profilNotifId;
    }




    /**
     * @param int $profilNotifId
     */
    public function setProfilNotifId($profilNotifId)
    {
        $this->profilNotifId = $profilNotifId;
    }

    /**
     * @return boolean
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @param boolean $active
     */
    public function setActive($active)
    {
        $this->active = $active;
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
     * @return Notification
     */
    public function getNotification()
    {
        return $this->notification;
    }

    /**
     * @param Notification $notification
     */
    public function setNotification($notification)
    {
        $this->notification = $notification;
    }

    /**
     * @return TypeNotification
     */
    public function getTypeNotification()
    {
        return $this->typeNotification;
    }

    /**
     * @param TypeNotification $typeNotification
     */
    public function setTypeNotification($typeNotification)
    {
        $this->typeNotification = $typeNotification;
    }


}
