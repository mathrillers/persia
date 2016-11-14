<?php
/**
 * Created by PhpStorm.
 * User: Matt
 * Date: 17/03/2016
 * Time: 17:27
 */

namespace AppBundle\Services;


use AppBundle\Entity\Annonce;
use AppBundle\Entity\InfoAnnonce;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
class CounterService
{
private $session;
    private $user;

    private $container;
 private $em;


    /**
     * CounterService constructor.
     * @param $container
     */
    public function __construct(Container $container,EntityManager $em)
    {
        $this->session = new Session();
        $this->container = $container;
        $this->em=$em;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }


    /**
     * @return mixed
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * @param mixed $session
     */
    public function setSession($session)
    {
        $this->session = $session;
    }


    public function  getMacAddress()
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        $mac_string = shell_exec("arp -a $ip");
        $mac_array = explode(" ", $mac_string);

        foreach ($mac_array as $mac) {
            if (filter_var($mac, FILTER_VALIDATE_MAC)) {
            return $mac;
            }
        }
        return null;
    }

    public function  getIpAddress()
    {
      return  $this->container->get('request_stack')->getMasterRequest()->getClientIp();
    }



public function countViewAnonymus(Annonce $annonce){
    if(! $this->session->has('AnnonceId_'.$annonce->getAnnonceId()))
    {
      $this->session->set('AnnonceId_'.$annonce->getAnnonceId(),$annonce->getAnnonceId());
        $this->incrementCounter($annonce);
        return true;
    }
    return false;
}

    public function countViewAuthen(Annonce $annonce)
    {
        $count=false;
        $info = $this->em->getRepository('AppBundle:InfoAnnonce')
            ->findOneBy(array('personneid' => $this->user->getPersonne(), 'annonceid' => $annonce));
        if ($info) {

            if ($info->isVue() != true) {
                $info->setVue(true);

                $this->em->merge($info);
             $count=true;
            }
        }
        else{
                $info=new InfoAnnonce();
            $info->setAnnonceid($annonce);
            $info->setPersonneid($this->user->getPersonne());
            $info->setVue(true);
            $this->em->persist($info);
            $count=true;
            }
        if($count) $this->incrementCounter($annonce);

        return $count;
    }

    public function incrementCounter(Annonce $annonce){
        if($annonce->getNbreVues()==null){
            $c=0;
        }else{
            $c=$annonce->getNbreVues();
        }

        $annonce->setNbreVues(++$c );

        $this->em->merge($annonce);
        $this->em->flush();
    }


    public function addFavorites(Annonce $annonce)
    {
        $count=false;
        $info = $this->em->getRepository('AppBundle:InfoAnnonce')
            ->findOneBy(array('personneid' => $this->user->getPersonne(), 'annonceid' => $annonce));
        if ($info) {

            if ($info->getFavori() != true) {
                $info->setFavori(true);

                $this->em->merge($info);
                $count=true;
            }
        }
        else{
            $info=new InfoAnnonce();
            $info->setAnnonceid($annonce);
            $info->setPersonneid($this->user->getPersonne());
            $info->setFavori(true);
            $this->em->persist($info);
            $count=true;
        }
        $this->em->flush();
        return $count;
    }

    public function removeFavorites(Annonce $annonce)
    {
        $count=false;
        $info = $this->em->getRepository('AppBundle:InfoAnnonce')
            ->findOneBy(array('personneid' => $this->user->getPersonne(), 'annonceid' => $annonce));
        if ($info) {

            if ($info->getFavori() == true) {
                $info->setFavori(false);

                $this->em->merge($info);
                $count=true;
            }
        }
        $this->em->flush();
        return $count;
    }
}
