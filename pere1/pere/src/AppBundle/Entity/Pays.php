<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;


/**
 * Pays
 *
 * @ORM\Table(name="pays")
 * * @ORM\Entity()
 */
class Pays
{
    /**
     * @var integer
     *
     * @ORM\Column(name="paysId", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $paysId;


    /**
     * @var string
     *
     * @ORM\Column(name="paysNom", type="string", length=254, nullable=true)
     */
    private $paysNom;

    /**
     * @return int
     */
    public function getPaysId()
    {
        return $this->paysId;
    }

    /**
     * @param int $paysId
     */
    public function setPaysId($paysId)
    {
        $this->paysId = $paysId;
    }

    /**
     * @return string
     */
    public function getPaysNom()
    {
        return $this->paysNom;
    }

    /**
     * @param string $paysNom
     */
    public function setPaysNom($paysNom)
    {
        $this->paysNom = $paysNom;
    }

    function __toString()
    {
        // TODO: Implement __toString() method.
        return "" . $this->getPaysNom();
    }


}
