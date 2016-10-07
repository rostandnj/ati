<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Type;

/**
 * Magasin
 *
 * @ORM\Table(name="magasin")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MagasinRepository")
 * @ExclusionPolicy("none")
 */
class Magasin extends Model\JsonObject
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="localisation", type="string", length=255)
     */
    private $localisation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;


    /**
     * @var Antenne
     *
     * @ORM\ManyToOne(targetEntity="Antenne",inversedBy="magasins" )
     */
    private $antenne;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="StockProduit", mappedBy="magasin")
     */
    private $stocks;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Entree", mappedBy="magasin")
     */
    private $entrees;

     /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Sortie", mappedBy="magasin")
     */
    private $sorties;

    /**
     * @var boolean
     *
     * @ORM\Column(name="actif", type="boolean")
     */
    private $actif;

    

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
     * Set nom
     *
     * @param string $nom
     *
     * @return Magasin
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set localisation
     *
     * @param string $localisation
     *
     * @return Magasin
     */
    public function setLocalisation($localisation)
    {
        $this->localisation = $localisation;

        return $this;
    }

    /**
     * Get localisation
     *
     * @return string
     */
    public function getLocalisation()
    {
        return $this->localisation;
    }

    /**
     * Set antenne
     *
     * @param \AppBundle\Entity\Antenne $antenne
     *
     * @return Magasin
     */
    public function setAntenne(\AppBundle\Entity\Antenne $antenne = null)
    {
        $this->antenne = $antenne;

        return $this;
    }

    /**
     * Get antenne
     *
     * @return \AppBundle\Entity\Antenne
     */
    public function getAntenne()
    {
        return $this->antenne;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->stocks = new \Doctrine\Common\Collections\ArrayCollection();

        $this->date = new \DateTime();
        $this->actif = true;
   
    }

    /**
     * Add stock
     *
     * @param \AppBundle\Entity\StockProduit $stock
     *
     * @return Magasin
     */
    public function addStock(\AppBundle\Entity\StockProduit $stock)
    {
        $this->stocks[] = $stock;

        return $this;
    }

    /**
     * Remove stock
     *
     * @param \AppBundle\Entity\StockProduit $stock
     */
    public function removeStock(\AppBundle\Entity\StockProduit $stock)
    {
        $this->stocks->removeElement($stock);
    }

    /**
     * Get stocks
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStocks()
    {
        return $this->stocks;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Magasin
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set actif
     *
     * @param boolean $actif
     *
     * @return Magasin
     */
    public function setActif($actif)
    {
        $this->actif = $actif;

        return $this;
    }

    /**
     * Get actif
     *
     * @return boolean
     */
    public function getActif()
    {
        return $this->actif;
    }

    /**
     * Add entree
     *
     * @param \AppBundle\Entity\Entree $entree
     *
     * @return Magasin
     */
    public function addEntree(\AppBundle\Entity\Entree $entree)
    {
        $this->entrees[] = $entree;

        return $this;
    }

    /**
     * Remove entree
     *
     * @param \AppBundle\Entity\Entree $entree
     */
    public function removeEntree(\AppBundle\Entity\Entree $entree)
    {
        $this->entrees->removeElement($entree);
    }

    /**
     * Get entrees
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEntrees()
    {
        return $this->entrees;
    }

    /**
     * Add sorty
     *
     * @param \AppBundle\Entity\Sortie $sorty
     *
     * @return Magasin
     */
    public function addSorty(\AppBundle\Entity\Sortie $sorty)
    {
        $this->sorties[] = $sorty;

        return $this;
    }

    /**
     * Remove sorty
     *
     * @param \AppBundle\Entity\Sortie $sorty
     */
    public function removeSorty(\AppBundle\Entity\Sortie $sorty)
    {
        $this->sorties->removeElement($sorty);
    }

    /**
     * Get sorties
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSorties()
    {
        return $this->sorties;
    }
}
