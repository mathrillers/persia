<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Postuler
 *
 * @ORM\Table(name="postuler", indexes={@ORM\Index(name="personne_Id", columns={"personne_Id"}), @ORM\Index(name="FK_post", columns={"annonce_Id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PostulerRepository")
 */
class Postuler
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_post", type="datetime", nullable=true)
     */
    private $datePost;

    /**
     * @var string
     *
     * @ORM\Column(name="statut", type="string", length=254, nullable=true)
     */
    private $statut;

    /**
     * @var integer
     *
     * @ORM\Column(name="post_ID", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $postId;

    /**
     * @var \AppBundle\Entity\Annonce
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Annonce",cascade={"persist","remove"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="annonce_Id", referencedColumnName="annonce_ID")
     * })
     */
    private $annonce;

    /**
     * @var \AppBundle\Entity\Personne
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Personne")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="personne_Id", referencedColumnName="personne_ID")
     * })
     */
    private $personne;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Reservation", mappedBy="postuler")
     */

    private $reservation;


    /**
     * @var float
     *
     * @ORM\Column(name="post_montant", type="float", precision=11, scale=2, nullable=true)
     */
    private $postMontant;

    /**
     * @return float
     */
    public function getPostMontant()
    {
        return $this->postMontant;
    }

    /**
     * @param float $postMontant
     */
    public function setPostMontant($postMontant)
    {
        $this->postMontant = $postMontant;
    }


    /**
     * Set reservation
     *
     * @param \AppBundle\Entity\Reservation $reservation
     *
     * @return Annonce
     */
    public function setReservation(\AppBundle\Entity\Reservation $reservation = null)
    {
        $this->reservation = $reservation;

        return $this;
    }

    /**
     * Get reservation
     *
     * @return \AppBundle\Entity\Reservation
     */
    public function getReservation()
    {
        return $this->reservation;
    }
    /**
     * Set datePost
     *
     * @param \DateTime $datePost
     *
     * @return Postuler
     */
    public function setDatePost($datePost)
    {
        $this->datePost = $datePost;

        return $this;
    }

    /**
     * Get datePost
     *
     * @return \DateTime
     */
    public function getDatePost()
    {
        return $this->datePost;
    }

    /**
     * Set statut
     *
     * @param string $statut
     *
     * @return Postuler
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * Get statut
     *
     * @return string
     */
    public function getStatut()
    {
        return $this->statut;
    }

    /**
     * Get postId
     *
     * @return integer
     */
    public function getPostId()
    {
        return $this->postId;
    }

    /**
     * Set annonce
     *
     * @param \AppBundle\Entity\Annonce $annonce
     *
     * @return Postuler
     */
    public function setAnnonce(\AppBundle\Entity\Annonce $annonce = null)
    {
        $this->annonce = $annonce;

        return $this;
    }

    /**
     * Get annonce
     *
     * @return \AppBundle\Entity\Annonce
     */
    public function getAnnonce()
    {
        return $this->annonce;
    }

    /**
     * Set personne
     *
     * @param \AppBundle\Entity\Personne $personne
     *
     * @return Postuler
     */
    public function setPersonne(\AppBundle\Entity\Personne $personne = null)
    {
        $this->personne = $personne;

        return $this;
    }

    /**
     * Get personne
     *
     * @return \AppBundle\Entity\Personne
     */
    public function getPersonne()
    {
        return $this->personne;
    }
}
