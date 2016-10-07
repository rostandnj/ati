<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Type;

/**
 * StockProduit
 *
 * @ORM\Table(name="stockproduit")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\StockProduitRepository")
 * @ExclusionPolicy("none")
 */
class StockProduit extends Model\JsonObject
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
     * @var int
     *
     * @ORM\Column(name="quantite", type="integer")
     */
    private $quantite;


    /**
     * @var Magasin
     *
     * @ORM\ManyToOne(targetEntity="Magasin", inversedBy="stocks")
     */
    private $magasin;

    /**
     * @var Article
     *
     * @ORM\ManyToOne(targetEntity="Article")
     */
    private $article;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Entree", mappedBy="stock",fetch="EXTRA_LAZY")
     */
    private $entrees;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Sortie", mappedBy="stock",fetch="EXTRA_LAZY")
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
     * Set quantite
     *
     * @param integer $quantite
     *
     * @return Stockproduit
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;

        return $this;
    }

    /**
     * Get quantite
     *
     * @return integer
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * Set magasin
     *
     * @param \AppBundle\Entity\Magasin $magasin
     *
     * @return Stockproduit
     */
    public function setMagasin(\AppBundle\Entity\Magasin $magasin = null)
    {
        $this->magasin = $magasin;

        return $this;
    }

    /**
     * Get magasin
     *
     * @return \AppBundle\Entity\Magasin
     */
    public function getMagasin()
    {
        return $this->magasin;
    }

    /**
     * Set article
     *
     * @param \AppBundle\Entity\Article $article
     *
     * @return Stockproduit
     */
    public function setArticle(\AppBundle\Entity\Article $article = null)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get article
     *
     * @return \AppBundle\Entity\Article
     */
    public function getArticle()
    {
        return $this->article;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->entrees = new \Doctrine\Common\Collections\ArrayCollection();
        $this->sorties = new \Doctrine\Common\Collections\ArrayCollection();

        $this->date = new \DateTime();
        $this->actif = true;
    
    }

    /**
     * Add entree
     *
     * @param \AppBundle\Entity\Entree $entree
     *
     * @return Stockproduit
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
     * @return Stockproduit
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

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Stockproduit
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
     * @return StockProduit
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
