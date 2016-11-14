<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Annonce
 *
 * @ORM\Table(name="annonce", indexes={@ORM\Index(name="FK_Association_5", columns={"immobilier_ID"}), @ORM\Index(name="FK_deposer", columns={"depositaire_ID"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AnnonceRepository")
 */
class Annonce
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
     * @ORM\Column(name="titre", type="string", length=254, nullable=true)
     */
    private $titre;
    /**
     * @var string
     *
     * @ORM\Column(name="type_annonce", type="string", length=254, nullable=true)
     */
    private $typeAnnonce;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=254, nullable=true)
     */
    private $description;

    /**
     * @var float
     *
     * @ORM\Column(name="montant", type="float", precision=11, scale=2, nullable=true)
     */
    private $montant;

    /**
     * @var float
     *
     * @ORM\Column(name="prix_delai", type="float", precision=11, scale=2, nullable=true)
     */
    private $prixDelai;

    /**
     * @var integer
     *
     * @ORM\Column(name="periode_delai", type="integer", nullable=true)
     */
    private $periodeDelai;
    /**
     * @var boolean
     *
     * @ORM\Column(name="type_delai", type="boolean", nullable=true)
     */
    private $typeDelai;


    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=254, nullable=true)
     */
    private $etat;

    /**
     * @var float
     *
     * @ORM\Column(name="commission", type="float", precision=2, scale=2, nullable=true)
     */
    private $commission;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbre_vues", type="bigint", nullable=true)
     */
    private $nbreVues;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_depot", type="datetime", nullable=true)
     */
    private $dateDepot;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_publication", type="datetime", nullable=true)
     */
    private $datePublication;

    /**
     * @var string
     *
     * @ORM\Column(name="statut_depot", type="string", length=254, nullable=true)
     */
    private $statutDepot;

    /**
     * @var integer
     *
     * @ORM\Column(name="annonce_ID", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $annonceId;

    /**
     * @var \AppBundle\Entity\Personne
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Personne")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="depositaire_ID", referencedColumnName="personne_ID")
     * })
     */
    private $depositaire;



    /**
     * @var \AppBundle\Entity\Immobilier
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Immobilier",cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="immobilier_ID", referencedColumnName="immobilier_ID")
     * })
     */
    private $immobilier;

    /**
     * @return float
     */
    public function getPrixDelai()
    {
        return $this->prixDelai;
    }

    /**
     * @param float $prixDelai
     */
    public function setPrixDelai($prixDelai)
    {
        $this->prixDelai = $prixDelai;
    }

    /**
     * @return int
     */
    public function getPeriodeDelai()
    {
        return $this->periodeDelai;
    }

    /**
     * @param int $periodeDelai
     */
    public function setPeriodeDelai($periodeDelai)
    {
        $this->periodeDelai = $periodeDelai;
    }

    /**
     * @return boolean
     */
    public function isTypeDelai()
    {
        return $this->typeDelai;
    }

    /**
     * @param boolean $typeDelai
     */
    public function setTypeDelai($typeDelai)
    {
        $this->typeDelai = $typeDelai;
    }



    /**
     * Set reference
     *
     * @param string $reference
     *
     * @return Annonce
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
     * Set typeAnnonce
     *
     * @param string $typeAnnonce
     *
     * @return Annonce
     */
    public function setTypeAnnonce($typeAnnonce)
    {
        $this->typeAnnonce = $typeAnnonce;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * @param string $titre
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
    }

    /**
     * Get typeAnnonce
     *
     * @return string
     */
    public function getTypeAnnonce()
    {
        return $this->typeAnnonce;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Annonce
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set montant
     *
     * @param float $montant
     *
     * @return Annonce
     */
    public function setMontant($montant)
    {
        $this->montant = $montant;

        return $this;
    }

    /**
     * Get montant
     *
     * @return float
     */
    public function getMontant()
    {
        return $this->montant;
    }

    /**
     * Set etat
     *
     * @param string $etat
     *
     * @return Annonce
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return string
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * Set commission
     *
     * @param float $commission
     *
     * @return Annonce
     */
    public function setCommission($commission)
    {
        $this->commission = $commission;

        return $this;
    }

    /**
     * Get commission
     *
     * @return float
     */
    public function getCommission()
    {
        return $this->commission;
    }

    /**
     * Set nbreVues
     *
     * @param integer $nbreVues
     *
     * @return Annonce
     */
    public function setNbreVues($nbreVues)
    {
        $this->nbreVues = $nbreVues;

        return $this;
    }

    /**
     * Get nbreVues
     *
     * @return integer
     */
    public function getNbreVues()
    {
        return $this->nbreVues;
    }

    /**
     * Set dateDepot
     *
     * @param \DateTime $dateDepot
     *
     * @return Annonce
     */
    public function setDateDepot($dateDepot)
    {
        $this->dateDepot = $dateDepot;

        return $this;
    }

    /**
     * Get dateDepot
     *
     * @return \DateTime
     */
    public function getDateDepot()
    {
        return $this->dateDepot;
    }

    /**
     * Set datePublication
     *
     * @param \DateTime $datePublication
     *
     * @return Annonce
     */
    public function setDatePublication($datePublication)
    {
        $this->datePublication = $datePublication;

        return $this;
    }

    /**
     * Get datePublication
     *
     * @return \DateTime
     */
    public function getDatePublication()
    {
        return $this->datePublication;
    }

    /**
     * Set statutDepot
     *
     * @param string $statutDepot
     *
     * @return Annonce
     */
    public function setStatutDepot($statutDepot)
    {
        $this->statutDepot = $statutDepot;

        return $this;
    }

    /**
     * Get statutDepot
     *
     * @return string
     */
    public function getStatutDepot()
    {
        return $this->statutDepot;
    }

    /**
     * Get annonceId
     *
     * @return integer
     */
    public function getAnnonceId()
    {
        return $this->annonceId;
    }

    /**
     * Set depositaire
     *
     * @param \AppBundle\Entity\Personne $depositaire
     *
     * @return Annonce
     */
    public function setDepositaire(\AppBundle\Entity\Personne $depositaire = null)
    {
        $this->depositaire = $depositaire;

        return $this;
    }

    /**
     * Get depositaire
     *
     * @return \AppBundle\Entity\Personne
     */
    public function getDepositaire()
    {
        return $this->depositaire;
    }



    /**
     * Set immobilier
     *
     * @param \AppBundle\Entity\Immobilier $immobilier
     *
     * @return Annonce
     */
    public function setImmobilier(\AppBundle\Entity\Immobilier $immobilier = null)
    {
        $this->immobilier = $immobilier;

        return $this;
    }

    /**
     * Get immobilier
     *
     * @return \AppBundle\Entity\Immobilier
     */
    public function getImmobilier()
    {
        return $this->immobilier;
    }

    public function __toString(){
        return "".$this->getTitre();
    }
}
