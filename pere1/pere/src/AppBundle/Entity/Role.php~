<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Role\RoleInterface;

/**
 * Role
 *
 * @ORM\Table(name="role")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RoleRepository")
 */
class Role implements RoleInterface
{
    /**
     * @var string
     *
     * @ORM\Column(name="role_Nom", type="string", length=254, nullable=true)
     */
    private $roleNom;

    /**
     * @var integer
     *
     * @ORM\Column(name="role_ID", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $roleId;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Compte", mappedBy="role")
     */
    private $compte;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->compte = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Set roleNom
     *
     * @param string $roleNom
     *
     * @return Role
     */
    public function setRoleNom($roleNom)
    {
        $this->roleNom = $roleNom;

        return $this;
    }

    /**
     * Get roleNom
     *
     * @return string
     */
    public function getRoleNom()
    {
        return $this->roleNom;
    }

    /**
     * Get roleId
     *
     * @return integer
     */
    public function getRoleId()
    {
        return $this->roleId;
    }

    /**
     * Add compte
     *
     * @param \AppBundle\Entity\Compte $compte
     *
     * @return Role
     */
    public function addCompte(\AppBundle\Entity\Compte $compte)
    {
        $this->compte[] = $compte;

        return $this;
    }

    /**
     * Remove compte
     *
     * @param \AppBundle\Entity\Compte $compte
     */
    public function removeCompte(\AppBundle\Entity\Compte $compte)
    {
        $this->compte->removeElement($compte);
    }

    /**
     * Get compte
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCompte()
    {
        return $this->compte;
    }

    /**
     * Returns the role.
     *
     * This method returns a string representation whenever possible.
     *
     * When the role cannot be represented with sufficient precision by a
     * string, it should return null.
     *
     * @return string|null A string representation of the role, or null
     */
    public function getRole()
    {
        return $this->getRoleNom();
    }

    public function __toString()
    {
        return "".$this->getRoleNom();
    }
}
