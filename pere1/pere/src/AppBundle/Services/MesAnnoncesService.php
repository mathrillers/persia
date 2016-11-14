<?php
/**
 * Created by PhpStorm.
 * User: Matt
 * Date: 15/02/2016
 * Time: 11:46
 */

namespace AppBundle\Services;


use AppBundle\Entity\Annonce;
use AppBundle\Repository\ImmobilierRepository;
use AppBundle\Repository\PostulerRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use AppBundle\Repository\AnnonceRepository;
use Symfony\Component\Security\Core\User\UserInterface;

class MesAnnoncesService
{
     private $user;

    private $agence;
    /***
     * @var array
     */
    private $annonces;
    /***
     * @var array
     */
    private $postuler;
    /***
     * @var array
     */
    private $reservations;
    /***
     * @var array
     */
    private $infoAnnonce;
    /***
     * @var array
     */
    private $depots;

    /***
     * @var array
     */
    private $favoris;
    /***
     * @var array
     */
    private $jaimes;
    /***
     * @var float
     */
    private $maxVente;
    /***
     * @var float
     */
    private $minVente;
    /***
     * @var float
     */
    private $maxLoc;
    /***
     * @var float
     */
    private $minLoc;

    private $em;


    /**
    * @param EntityManager $em
    */

    public function __construct(EntityManager $em, $name)
    {
        $this->em = $em;
        $this->agence=$name;
    }

    /**
     * @return mixed
     */
    public function getAgence()
    {

        return $this->em->getRepository('AppBundle:Agence')
            ->findOneByNom($this->agence);
    }

    /**
     * @param mixed $agence
     */
    public function setAgence($agence)
    {
        $this->agence = $agence;
    }

    /**
     * @return float
     */
    public function getMaxVente()
    {
      $this->maxVente =$this->em
            ->getRepository('AppBundle:Annonce')
            ->findMaxVente();
/*        var_dump( $this->maxVente['maxs']);
        die();*/

        if($this->maxVente==null) return $this->maxVente=0;

        return $this->maxVente;
    }

    /**
     * @param float $maxVente
     */
    public function setMaxVente($maxVente)
    {
        $this->maxVente = $maxVente;
    }

    /**
     * @return float
     */
    public function getMinVente()
    {
      $this->minVente= $this->em
            ->getRepository('AppBundle:Annonce')
            ->findMinVente();


        if($this->minVente==null) return $this->minVente=0;

        return $this->minVente;
    }

    /**
     * @param float $minVente
     */
    public function setMinVente($minVente)
    {
        $this->minVente = $minVente;
    }

    /**
     * @return float
     */
    public function getMaxLoc()
    {
        $this->maxLoc= $this->em
            ->getRepository('AppBundle:Annonce')
            ->findMaxLoc();


        if($this->maxLoc==null) return $this->maxLoc=0;

        return $this->maxLoc;
    }

    /**
     * @param float $maxLoc
     */
    public function setMaxLoc($maxLoc)
    {
        $this->maxLoc = $maxLoc;
    }

    /**
     * @return float
     */
    public function getMinLoc()
    {
        $this->minLoc= $this->em
            ->getRepository('AppBundle:Annonce')
            ->findMinLoc();


        if($this->minLoc==null) return $this->minLoc=0;

        return $this->minLoc;
    }

    /**
     * @param float $minLoc
     */
    public function setMinLoc($minLoc)
    {
        $this->minLoc = $minLoc;
    }

    /**
     * @return array
     */
    public function getReservations()
    {$this->getPostuler();
        foreach ($this->postuler as $post){
           $p=$this->em
                ->getRepository('AppBundle:Reservation')
                ->findOneByPostuler($post);
            if($p) $this->reservations[]=$p;
        }



        return $this->reservations;
    }

    /**
     * @param array $reservations
     */
    public function setReservations($reservations)
    {
        $this->reservations = $reservations;
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
     * @return Annonce[]
     */
    public function getAnnonces()
    {

        return $this->annonces;
    }

    /**
     * @param array $annonces
     */
    public function setAnnonces($annonces)
    {
        $this->annonces = $annonces;
    }

    /**
     * @return array
     */
    public function getPostuler()
    {
        return $this->postuler = $this->em
            ->getRepository('AppBundle:Postuler')
            ->findByPersonne($this->user->getPersonne());
    }

    /**
     * @param array $postuler
     */
    public function setPostuler($postuler)
    {
        $this->postuler = $postuler;
    }

    /**
     * @return array
     */
    public function getInfoAnnonce()
    {

        return  $this->infoAnnonce = $this
                            ->em
                            ->getRepository('AppBundle:InfoAnnonce')
                            ->findByPersonneid($this->user->getPersonne())
            ;


    }

    /**
     * @param array $info
     */
    public function setInfoAnnonce($info)
    {
        $this->infoAnnonce = $info;
    }

    /**
     * @return array
     */
    public function getDepots()
    {
        return  $this->depots =
                            $this->em
                                ->getRepository('AppBundle:Annonce')
                              ->findByDepositaire($this->user->getPersonne());
    }

    /**
     * @param array $depots
     */
    public function setDepots($depots)
    {
        $this->depots = $depots;
    }


    /**
     * @return array
     */
    public function getFavoris()
    {
        return $this->favoris=
            $this->em
                ->getRepository('AppBundle:InfoAnnonce')
                ->allFavorisPers($this->user->getPersonne());
    }

    /**
     * @param array $favoris
     */
    public function setFavoris($favoris)
    {
        $this->favoris = $favoris;
    }

    /**
     * @return array
     */
    public function getJaimes()
    {
        return $this->jaimes=
            $this->em
                ->getRepository('AppBundle:InfoAnnonce')
                ->allJaimePers($this->user->getPersonne());
    }

    /**
     * @param array $jaimes
     */
    public function setJaimes($jaimes)
    {
        $this->jaimes = $jaimes;
    }


    public function mesAnnoncesPost($listPost)
    {
    $this->annonces=array();

        foreach ($listPost as $post) {

            $an = $this->em
                ->getRepository('AppBundle:Annonce')
                ->findOneByAnnonceId($post->getAnnonce());
            $this->annonces[]=$an;
        }
    return $this->annonces;
    }
    public function mesAnnoncesFavori($listFav)
    {
        $this->annonces=array();

        foreach ($listFav as $favoris) {

            $this->annonces[] = $this->em
                ->getRepository('AppBundle:Annonce')
                ->findOneByAnnonceId($favoris->getAnnonceid());

        }
        return $this->annonces;
    }
    public function mesAnnoncesJaime($listJaime)
    {
        $this->annonces=array();

        foreach ($listJaime as $jaime) {

            $an = $this->em
                ->getRepository('AppBundle:Annonce')
                ->findOneByAnnonceId($jaime->getAnnonceid());
            $this->annonces[]=$an;
        }
        return $this->annonces;
    }
    public function mesAnnoncesReservees($listReserv)
    {
        $this->annonces=array();
if($listReserv){
        foreach ($listReserv as $r) {

            $post= $this->em
                ->getRepository('AppBundle:Postuler')
                ->find($r->getPostuler());

            $this->annonces[]=$post->getAnnonce();
        }
}
        return $this->annonces;
  }
}