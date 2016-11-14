<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;


/**
 * Ville
 *
 * @ORM\Table(name="quartier")
 * * @ORM\Entity()
 */
class Quartier
{
    /**
     * @var integer
     *
     * @ORM\Column(name="quartier_ID", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $quartierId;


    /**
     * @var string
     *
     * @ORM\Column(name="quartier_nom", type="string", length=254, nullable=true)
     */
    private $quartierNom;


    /**
     * @var integer
     *
     * @ORM\Column(name="quartier_code_postale", type="integer", nullable=true)
     */
    private $quartierPostale;


    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Ville")
     * @ORM\JoinColumn(name="ville_ID", referencedColumnName="ville_ID")
     */
    private $ville;

    /**
     * @return mixed
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * @param mixed $ville
     */
    public function setVille($ville)
    {
        $this->ville = $ville;
    }


    /**
     * @return int
     */
    public function getQuartierId()
    {
        return $this->quartierId;
    }

    /**
     * @param int $quartierId
     */
    public function setQuartierId($quartierId)
    {
        $this->quartierId = $quartierId;
    }

    /**
     * @return string
     */
    public function getQuartierNom()
    {
        return $this->quartierNom;
    }

    /**
     * @param string $quartierNom
     */
    public function setQuartierNom($quartierNom)
    {
        $this->quartierNom = $quartierNom;
    }

    /**
     * @return int
     */
    public function getQuartierPostale()
    {
        return $this->quartierPostale;
    }

    /**
     * @param int $quartierPostale
     */
    public function setQuartierPostale($quartierPostale)
    {
        $this->quartierPostale = $quartierPostale;
    }


public function __toString(){
    return $this->getQuartierNom();
}

}