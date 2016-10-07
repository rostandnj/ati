<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Type;

/**
 * Article
 *
 * @ORM\Table(name="stat_stock")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\StatStockRepository")
 * @ExclusionPolicy("none")
 */
class StatStock extends Model\JsonObject
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
     * @var StockProduit
     *
     * @ORM\OneToOne(targetEntity="StockProduit")
     */
    private $stock;

    /**
     * @var int
     *
     * @ORM\Column(name="year", type="integer")
     */
    private $year;

    /**
     * @var int
     *
     * @ORM\Column(name="month", type="integer")
     */
    private $month;

    /**
     * @var int
     *
     * @ORM\Column(name="entree", type="integer")
     */
    private $entree; 

    /**
     * @var int
     *
     * @ORM\Column(name="sortie", type="integer")
     */
    private $sortie;

    /**
     * @var float
     *
     * @ORM\Column(name="freq_sortie", type="float")
     */
    private $freqSortie;

    /**
     * @var float
     *
     * @ORM\Column(name="freq_entree", type="float")
     */
    private $freqEntree;

    /**
     * @var boolean
     *
     * @ORM\Column(name="actif", type="boolean")
     */
    private $actif;

    /**
     * Constructor
     */
    public function __construct()
    {
        
        $this->actif =true;
    }



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
     * Set year
     *
     * @param integer $year
     *
     * @return StatStock
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return integer
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set month
     *
     * @param integer $month
     *
     * @return StatStock
     */
    public function setMonth($month)
    {
        $this->month = $month;

        return $this;
    }

    /**
     * Get month
     *
     * @return integer
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * Set entree
     *
     * @param integer $entree
     *
     * @return StatStock
     */
    public function setEntree($entree)
    {
        $this->entree = $entree;

        return $this;
    }

    /**
     * Get entree
     *
     * @return integer
     */
    public function getEntree()
    {
        return $this->entree;
    }

    /**
     * Set sortie
     *
     * @param integer $sortie
     *
     * @return StatStock
     */
    public function setSortie($sortie)
    {
        $this->sortie = $sortie;

        return $this;
    }

    /**
     * Get sortie
     *
     * @return integer
     */
    public function getSortie()
    {
        return $this->sortie;
    }

    /**
     * Set freqSortie
     *
     * @param float $freqSortie
     *
     * @return StatStock
     */
    public function setFreqSortie($freqSortie)
    {
        $this->freqSortie = $freqSortie;

        return $this;
    }

    /**
     * Get freqSortie
     *
     * @return float
     */
    public function getFreqSortie()
    {
        return $this->freqSortie;
    }

    /**
     * Set freqEntree
     *
     * @param float $freqEntree
     *
     * @return StatStock
     */
    public function setFreqEntree($freqEntree)
    {
        $this->freqEntree = $freqEntree;

        return $this;
    }

    /**
     * Get freqEntree
     *
     * @return float
     */
    public function getFreqEntree()
    {
        return $this->freqEntree;
    }

    /**
     * Set stock
     *
     * @param \AppBundle\Entity\StockProduit $stock
     *
     * @return StatStock
     */
    public function setStock(\AppBundle\Entity\StockProduit $stock = null)
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * Get stock
     *
     * @return \AppBundle\Entity\StockProduit
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * Set actif
     *
     * @param boolean $actif
     *
     * @return Antenne
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
}
