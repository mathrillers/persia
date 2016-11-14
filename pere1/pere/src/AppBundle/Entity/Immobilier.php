<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Immobilier
 *
 * @ORM\Table(name="immobilier", indexes={@ORM\Index(name="FK_Association_7", columns={"id_type"}), @ORM\Index(name="FK_Association_8", columns={"personne_ID"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ImmobilierRepository")
 */
class Immobilier
{
    /**
     * @var string
     *
     * @ORM\Column(name="reference", type="string", length=254, nullable=true)
     */
    private $reference;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=254, nullable=true)
     */
    private $adresse;

    /**
     * @var \AppBundle\Entity\Quartier
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Quartier")

     *   @ORM\JoinColumn(name="quartier_ID", referencedColumnName="quartier_ID")

     */
    private $quartier;
    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float", precision=11, scale=2, nullable=true)
     */
    private $prix;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbr_chambre", type="integer", nullable=true)
     */
    private $nbrChambre;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbre_salon", type="integer", nullable=true)
     */
    private $nbreSalon;

    /**
     * @var float
     *
     * @ORM\Column(name="superficie", type="float", precision=11, scale=2, nullable=true)
     */
    private $superficie;

    /**
     * @var boolean
     *
     * @ORM\Column(name="jardin", type="boolean", nullable=true)
     */
    private $jardin;

    /**
     * @var boolean
     *
     * @ORM\Column(name="garage", type="boolean", nullable=true)
     */
    private $garage;

    /**
     * @var boolean
     *
     * @ORM\Column(name="etat", type="boolean", nullable=true)
     */
    private $etat;

    /**
     * @var string
     *
     * @ORM\Column(name="main_image", type="string", length=254, nullable=true)
     */
    private $mainImage;
   /**
     * @var integer
     *
     * @ORM\Column(name="immobilier_ID", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $immobilierId;

    /**
     * @var \AppBundle\Entity\Personne
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Personne")

     *   @ORM\JoinColumn(name="personne_ID", referencedColumnName="personne_ID")

     */
    private $proprietaire;

    /**
     * @var \AppBundle\Entity\Typeimmobilier
     *
     * @ORM\ManyToOne(targetEntity="TypeImmobilier")

     *   @ORM\JoinColumn(name="id_type", referencedColumnName="id_type")

     */
    private $idType;

    /**
     * @return Quartier
     */
    public function getQuartier()
    {
        return $this->quartier;
    }

    /**
     * @param Quartier $quartier
     */
    public function setQuartier($quartier)
    {
        $this->quartier = $quartier;
    }


    /**
     * Set reference
     *
     * @param string $reference
     *
     * @return Immobilier
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference
     *
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     *
     * @return Immobilier
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }


    /**
     * Set prix
     *
     * @param float $prix
     *
     * @return Immobilier
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return float
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Set nbrChambre
     *
     * @param integer $nbrChambre
     *
     * @return Immobilier
     */
    public function setNbrChambre($nbrChambre)
    {
        $this->nbrChambre = $nbrChambre;

        return $this;
    }

    /**
     * Get nbrChambre
     *
     * @return integer
     */
    public function getNbrChambre()
    {
        return $this->nbrChambre;
    }

    /**
     * Set nbreSalon
     *
     * @param integer $nbreSalon
     *
     * @return Immobilier
     */
    public function setNbreSalon($nbreSalon)
    {
        $this->nbreSalon = $nbreSalon;

        return $this;
    }

    /**
     * Get nbreSalon
     *
     * @return integer
     */
    public function getNbreSalon()
    {
        return $this->nbreSalon;
    }

    /**
     * Set superficie
     *
     * @param float $superficie
     *
     * @return Immobilier
     */
    public function setSuperficie($superficie)
    {
        $this->superficie = $superficie;

        return $this;
    }

    /**
     * Get superficie
     *
     * @return float
     */
    public function getSuperficie()
    {
        return $this->superficie;
    }

    /**
     * Set jardin
     *
     * @param boolean $jardin
     *
     * @return Immobilier
     */
    public function setJardin($jardin)
    {
        $this->jardin = $jardin;

        return $this;
    }

    /**
     * Get jardin
     *
     * @return boolean
     */
    public function getJardin()
    {
        return $this->jardin;
    }

    /**
     * Set garage
     *
     * @param boolean $garage
     *
     * @return Immobilier
     */
    public function setGarage($garage)
    {
        $this->garage = $garage;

        return $this;
    }

    /**
     * Get garage
     *
     * @return boolean
     */
    public function getGarage()
    {
        return $this->garage;
    }

    /**
     * @return boolean
     */
    public function isEtat()
    {
        return $this->etat;
    }

    /**
     * @param boolean $etat
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;
    }

    /**
     * Get immobilierId
     *
     * @return integer
     */
    public function getImmobilierId()
    {
        return $this->immobilierId;
    }

    /**
     * @return Personne
     */
    public function getProprietaire()
    {
        return $this->proprietaire;
    }

    /**
     * @param Personne $proprietaire
     */
    public function setProprietaire($proprietaire)
    {
        $this->proprietaire = $proprietaire;
    }



    /**
     * Set idType
     *
     * @param \AppBundle\Entity\Typeimmobilier $idType
     *
     * @return Immobilier
     */
    public function setIdType(\AppBundle\Entity\Typeimmobilier $idType = null)
    {
        $this->idType = $idType;

        return $this;
    }

    /**
     * Get idType
     *
     * @return \AppBundle\Entity\Typeimmobilier
     */
    public function getIdType()
    {
        return $this->idType;
    }

    /**
     * @return string
     */
    public function getMainImage()
    {
        return $this->mainImage;
    }

    /**
     * @param string $mainImage
     */
    public function setMainImage($mainImage)
    {
        $this->mainImage = $mainImage;
    }

public function __toString(){
    return $this->getReference();
}
}
