<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;


/**
 * Ville
 *
 * @ORM\Table(name="ville")
 * * @ORM\Entity()
 */
class Ville
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ville_ID", type="string")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $villeId;


    /**
     * @var string
     *
     * @ORM\Column(name="ville_nom", type="string", length=254, nullable=true)
     */
    private $villeNom;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=254, nullable=true)
     */
    private $code;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Pays")
     * @ORM\JoinColumn(name="paysId", referencedColumnName="paysId")
     */
    private $pays;

    public function __construct()
    {

    }


    /**
     * @return int
     */
    public function getVilleId()
    {
        return $this->villeId;
    }

    /**
     * @param int $villeId
     */
    public function setVilleId($villeId)
    {
        $this->villeId = $villeId;
    }

    /**
     * @return string
     */
    public function getVilleNom()
    {
        return $this->villeNom;
    }

    /**
     * @param string $villeNom
     */
    public function setVilleNom($villeNom)
    {
        $this->villeNom = $villeNom;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return mixed
     */
    public function getPays()
    {
        return $this->pays;
    }

    /**
     * @param mixed $pays
     */
    public function setPays($pays)
    {
        $this->pays = $pays;
    }



    public function __toString()
    {

        return "" . $this->getVilleNom();
    }
}
