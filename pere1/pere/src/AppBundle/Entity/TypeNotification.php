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
 * TypeNotification
 *
 * @ORM\Table(name="type_notification")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TypeNotificationRepository")
 */
class TypeNotification
{
    /**
     * @var integer
     *
     * @ORM\Column(name="type_notif_ID", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */

    private  $typeNotifId;
    /**
     * @var string
     *
     * @ORM\Column(name="action", type="string", length=254, nullable=true)
     */
        private $action;
    /**
     * @var string
     *
     * @ORM\Column(name="entite", type="string",length=254, nullable=true)
     */
    private $entite;
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=254, nullable=true)
     */
    private $description;

    /**
     * @return int
     */
    public function getTypeNotifId()
    {
        return $this->typeNotifId;
    }

    /**
     * @param int $typeNotifId
     */
    public function setTypeNotifId($typeNotifId)
    {
        $this->typeNotifId = $typeNotifId;
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param string $action
     */
    public function setAction($action)
    {
        $this->action = $action;
    }

    /**
     * @return string
     */
    public function getEntite()
    {
        return $this->entite;
    }

    /**
     * @param string $entite
     */
    public function setEntite($entite)
    {
        $this->entite = $entite;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }




}