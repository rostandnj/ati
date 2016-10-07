<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Type;

/**
 * Projet
 *
 * @ORM\Table(name="projet")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProjetRepository")
 * @ExclusionPolicy("none")
 */
class Projet extends Model\JsonObject
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
     * @var string
     * @ORM\Column(name="moa", type="string")
     */
    private $moa;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datedebut", type="datetime")
     */
    private $dateDebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datefin", type="datetime")
     */
    private $dateFin;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="closedate", type="datetime",nullable=true)
     */
    private $closedate;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var int
     *
     * @ORM\Column(name="delais", type="integer")
     */
    private $delais;

    /**
     * @var boolean
     *
     * @ORM\Column(name="statut", type="boolean")
     */
    private $statut;

    /**
     * @var Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur",inversedBy="projets")
     */
    private $utilisateur;

    /**
     * @var Image
     *
     * @ORM\OneToOne(targetEntity="Image",cascade={"persist", "remove"})
     */
    private $image;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Depense", mappedBy="projet")
     */
    private $depenses;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Evolution", mappedBy="projet")
     */
    private $evolutions;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Blocage", mappedBy="projet")
     */
    private $blocages;

    /**
     * @var File
     *
     * @ORM\OneToOne(targetEntity="File",cascade={"persist", "remove"})
     */
    private $file;



    
    /**
     * Constructor
     */
    public function __construct()
    {
           $this->date = new \DateTime();
           $this->statut = false;
   
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
     * @return Projet
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
     * Set dateDebut
     *
     * @param \DateTime $dateDebut
     *
     * @return Projet
     */
    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    /**
     * Get dateDebut
     *
     * @return \DateTime
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * Set dateFin
     *
     * @param \DateTime $dateFin
     *
     * @return Projet
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    /**
     * Get dateFin
     *
     * @return \DateTime
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }

    /**
     * Set delais
     *
     * @param integer $delais
     *
     * @return Projet
     */
    public function setDelais($delais)
    {
        $this->delais = $delais;

        return $this;
    }

    /**
     * Get delais
     *
     * @return integer
     */
    public function getDelais()
    {
        return $this->delais;
    }

    /**
     * Set utilisateur
     *
     * @param \AppBundle\Entity\Utilisateur $utilisateur
     *
     * @return Projet
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
     * Add depense
     *
     * @param \AppBundle\Entity\Depense $depense
     *
     * @return Projet
     */
    public function addDepense(\AppBundle\Entity\Depense $depense)
    {
        $this->depenses[] = $depense;

        return $this;
    }

    /**
     * Remove depense
     *
     * @param \AppBundle\Entity\Depense $depense
     */
    public function removeDepense(\AppBundle\Entity\Depense $depense)
    {
        $this->depenses->removeElement($depense);
    }

    /**
     * Get depenses
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDepenses()
    {
        return $this->depenses;
    }

    /**
     * Add evolution
     *
     * @param \AppBundle\Entity\Evolution $evolution
     *
     * @return Projet
     */
    public function addEvolution(\AppBundle\Entity\Evolution $evolution)
    {
        $this->evolutions[] = $evolution;

        return $this;
    }

    /**
     * Remove evolution
     *
     * @param \AppBundle\Entity\Evolution $evolution
     */
    public function removeEvolution(\AppBundle\Entity\Evolution $evolution)
    {
        $this->evolutions->removeElement($evolution);
    }

    /**
     * Get evolutions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEvolutions()
    {
        return $this->evolutions;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Projet
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
     * Set moa
     *
     * @param string $moa
     *
     * @return Projet
     */
    public function setMoa($moa)
    {
        $this->moa = $moa;

        return $this;
    }

    /**
     * Get moa
     *
     * @return string
     */
    public function getMoa()
    {
        return $this->moa;
    }

    /**
     * Set statut
     *
     * @param integer $statut
     *
     * @return Projet
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * Get statut
     *
     * @return integer
     */
    public function getStatut()
    {
        return $this->statut;
    }

    /**
     * Add blocage
     *
     * @param \AppBundle\Entity\Blocage $blocage
     *
     * @return Projet
     */
    public function addBlocage(\AppBundle\Entity\Blocage $blocage)
    {
        $this->blocages[] = $blocage;

        return $this;
    }

    /**
     * Remove blocage
     *
     * @param \AppBundle\Entity\Blocage $blocage
     */
    public function removeBlocage(\AppBundle\Entity\Blocage $blocage)
    {
        $this->blocages->removeElement($blocage);
    }

    /**
     * Get blocages
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBlocages()
    {
        return $this->blocages;
    }

    /**
     * Set closedate
     *
     * @param \DateTime $closedate
     *
     * @return Projet
     */
    public function setClosedate($closedate)
    {
        $this->closedate = $closedate;

        return $this;
    }

    /**
     * Get closedate
     *
     * @return \DateTime
     */
    public function getClosedate()
    {
        return $this->closedate;
    }

    /**
     * Set image
     *
     * @param \AppBundle\Entity\Image $image
     *
     * @return Projet
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
     * Set file
     *
     * @param \AppBundle\Entity\File $file
     *
     * @return Projet
     */
    public function setFile(\AppBundle\Entity\File $file = null)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get file
     *
     * @return \AppBundle\Entity\File
     */
    public function getFile()
    {
        return $this->file;
    }
}
