<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Type;

/**
 * Entree
 *
 * @ORM\Table(name="entree")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EntreeRepository")
 * @ExclusionPolicy("none")
 */
class Entree extends Model\JsonObject
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
     * @ORM\Column(name="libelle", type="string", length=255)
     */
    private $libelle;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var int
     *
     * @ORM\Column(name="quantite", type="integer")
     */
    private $quantite;

    /**
     * @var Image
     *
     * @ORM\OneToOne(targetEntity="Image", cascade={"persist", "remove"})
     */
    private $image;

    /**
     * @var Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     */
    private $utilisateur;

    /**
     * @var StockProduit
     *
     * @ORM\ManyToOne(targetEntity="StockProduit", inversedBy="entrees")
     */
    private $stock;

    /**
     * @var Magasin
     *
     * @ORM\ManyToOne(targetEntity="Magasin", inversedBy="entrees")
     */
    private $magasin;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->date = new \DateTime();
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
     * Set libelle
     *
     * @param string $libelle
     *
     * @return Entree
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle
     *
     * @return string
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Entree
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
     * Set image
     *
     * @param \AppBundle\Entity\Image $image
     *
     * @return Entree
     */
    public function setImage(\AppBundle\Entity\Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \AppBundle\Entity\Image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set utilisateur
     *
     * @param \AppBundle\Entity\Utilisateur $utilisateur
     *
     * @return Entree
     */
    public function setUtilisateur(\AppBundle\Entity\Utilisateur $utilisateur = null)
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    /**
     * Get utilisateur
     *
     * @return \AppBundle\Entity\Utilisateur
     */
    public function getUtilisateur()
    {
        return $this->utilisateur;
    }

    /**
     * Set stockProduit
     *
     * @param \AppBundle\Entity\StockProduit $stockProduit
     *
     * @return Entree
     */
    public function setStockProduit(\AppBundle\Entity\StockProduit $stockProduit = null)
    {
        $this->stockProduit = $stockProduit;

        return $this;
    }

    /**
     * Get stockProduit
     *
     * @return \AppBundle\Entity\StockProduit
     */
    public function getStockProduit()
    {
        return $this->stockProduit;
    }

    /**
     * Set stock
     *
     * @param \AppBundle\Entity\StockProduit $stock
     *
     * @return Entree
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
     * Set quantite
     *
     * @param integer $quantite
     *
     * @return Entree
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
     * @return Entree
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
}
