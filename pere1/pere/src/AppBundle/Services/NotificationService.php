<?php
/**
 * Created by PhpStorm.
 * User: Matt
 * Date: 23/03/2016
 * Time: 16:12
 */

namespace AppBundle\Services;


use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class NotificationService
{    /**
 * @var \AppBundle\Entity\Compte
 *
 */
    private $user;

    private $em;

    private $count;
    private $tokenStorage;
    /**
     * @var \AppBundle\Entity\ProfilNotification[]
     *
     */
    private $notifications;

    /**
     * @var \AppBundle\Entity\ProfilNotification[]
     *
     */
    private $oldNotifs;
    /**
     * NotificationService constructor.
     * @param $em
     */
    public function __construct(EntityManager $em,TokenStorage $tokenStorage)
{
$this->tokenStorage = $tokenStorage;

        $this->em = $em;
       $this->getCount();
    }


    /**
     * @return \AppBundle\Entity\Compte
     */
    public function getUser()
    {   /* var_dump($this->tokenStorage->getToken());
        die();*/
if($this->tokenStorage->getToken()){
    $this->user=$this->tokenStorage->getToken()->getUser();
}

        return $this->user;
    }

    /**
     * @param \AppBundle\Entity\Compte $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getCount()
    {
        return $this->count=count($this->getNotifications()) ;
    }

    /**
     * @param mixed $count
     */
    public function setCount($count)
    {
        $this->count = $count;
    }

    /**
     * @return \AppBundle\Entity\ProfilNotification[]
     */
    public function getNotifications()
    {

        return $this->notifications=$this->em->getRepository('AppBundle:ProfilNotification') //  ->findAll();
           ->findBy(array('compte'=>$this->getUser(),'active'=>true), array('profilNotifId'=>'desc'));
    }

    /**
     * @param \AppBundle\Entity\ProfilNotification[] $notifications
     */
    public function setNotifications($notifications)
    {
        $this->notifications = $notifications;
    }

    /**
     * @return \AppBundle\Entity\ProfilNotification[]
     */
    public function getOldNotifs()
    {
        return $this->notifications=$this->em->getRepository('AppBundle:ProfilNotification')
        ->findBy(array('compte'=>$this->getUser(),'active'=>false), array('profilNotifId'=>'desc'));
    }

    /**
     * @param \AppBundle\Entity\ProfilNotification[] $oldNotifs
     */
    public function setOldNotifs($oldNotifs)
    {
        $this->oldNotifs = $oldNotifs;
    }


    /**
     * @return integer
     */
    public function adminNotifications()
    {

        $this->notifications = $this->em->getRepository('AppBundle:ProfilNotification')//  ->findAll();
        ->findBy(array('active' => true));
        return count($this->notifications);
    }

    /**
     * @return integer
     */
    public function entityNotifications($entity)
    {
        $this->notifications = array();
        $tp_not = $this->em->getRepository('AppBundle:TypeNotification')->findByEntite($entity);
        foreach ($tp_not as $t) {
            $a = $this->em->getRepository('AppBundle:ProfilNotification')//  ->findAll();
            ->findBy(array('active' => true, 'typeNotification' => $t));

            foreach ($a as $tr) {
                $this->notifications[] = $tr;
            }
        }

        return count($this->notifications);
    }

    /**
     * @return integer
     */
    public function listeNotifications()
    {
        /*       var_dump( count($this->notifications));
               die();*/
        $this->notifications = $this->em->getRepository('AppBundle:ProfilNotification')//  ->findAll();
        ->findBy(array('active' => true));
        return $this->notifications;
    }

}