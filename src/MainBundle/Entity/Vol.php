<?php

namespace MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use UserBundle\Entity\User;

/**
 * Vol
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MainBundle\Entity\VolRepository")
 */
class Vol
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="MainBundle\Entity\Ville")
     */
    private $villeDepart;

    /**
     * @ORM\ManyToOne(targetEntity="MainBundle\Entity\Ville")
     */
    private $villeArrivee;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     */
    private $pilote;

    /**
     * @ORM\ManyToOne(targetEntity="MainBundle\Entity\Avion")
     */
    private $avion;

    /**
     * @ORM\ManyToMany(targetEntity="UserBundle\Entity\User")
     */
    private $passagers;

    public function __construct()
    {
        $this->passagers = new ArrayCollection();
    }
    public function addPassager(User $passager)
    {
        $this->passagers[] = $passager;
        return $this;
    }
    public function removePassager(User $passager){
        $this->passagers->removeElement($passager);
    }
    public function getNbPlaceRestantes()
    {
        if($this->avion != null){
            return ($this->avion->getNbPlace() - count($this->passagers));
        }
        else{
            return "";
        }

    }
    /**
     * @var
     */
    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set villeDepart
     *
     * @param integer $villeDepart
     *
     * @return Vol
     */
    public function setVilleDepart($villeDepart)
    {
        $this->villeDepart = $villeDepart;

        return $this;
    }

    /**
     * Get villeDepart
     *
     * @return integer
     */
    public function getVilleDepart()
    {
        return $this->villeDepart;
    }

    /**
     * Set villeArrivee
     *
     * @param integer $villeArrivee
     *
     * @return Vol
     */
    public function setVilleArrivee($villeArrivee)
    {
        $this->villeArrivee = $villeArrivee;

        return $this;
    }

    /**
     * Get villeArrivee
     *
     * @return integer
     */
    public function getVilleArrivee()
    {
        return $this->villeArrivee;
    }

    /**
     * Set pilote
     *
     * @param integer $pilote
     *
     * @return Vol
     */
    public function setPilote($pilote)
    {
        $this->pilote = $pilote;

        return $this;
    }

    /**
     * Get pilote
     *
     * @return integer
     */
    public function getPilote()
    {
        return $this->pilote;
    }

    /**
     * Set passager
     *
     * @param array $passager
     *
     * @return Vol
     */
    public function setPassager($passager)
    {
        $this->passager = $passager;

        return $this;
    }

    /**
     * Get passager
     *
     * @return array
     */
    public function getPassager()
    {
        return $this->passager;
    }

    /**
     * Set avion
     *
     * @param \MainBundle\Entity\Avion $avion
     *
     * @return Vol
     */
    public function setAvion(\MainBundle\Entity\Avion $avion = null)
    {
        $this->avion = $avion;

        return $this;
    }

    /**
     * Get avion
     *
     * @return \MainBundle\Entity\Avion
     */
    public function getAvion()
    {
        return $this->avion;
    }

    /**
     * Get passagers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPassagers()
    {
        return $this->passagers;
    }
}
