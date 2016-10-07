<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Type;

/**
 * Courrier
 *
 * @ORM\Table(name="courrier")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CourrierRepository")
 * @ExclusionPolicy("none")
 */
class Courrier extends Model\JsonObject
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
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    

    /**
     * @var string
     *
     * @ORM\Column(name="emmetteur", type="string", length=255)
     */
    private $emetteur;

    /**
     * @var string
     *
     * @ORM\Column(name="recepteur", type="string", length=255)
     */
    private $recepteur;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var Image
     *
     * @ORM\OneToOne(targetEntity="Image", cascade={"persist", "remove"})
     */
    private $image;

    /**
     * @var Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur", inversedBy="courriers")
     */
    private $utilisateur;

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
     * @return Courrier
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
     * Set type
     *
     * @param string $type
     *
     * @return Courrier
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

   
    /**
     * Set emetteur
     *
     * @param string $emetteur
     *
     * @return Courrier
     */
    public function setEmetteur($emetteur)
    {
        $this->emetteur = $emetteur;

        return $this;
    }

    /**
     * Get emetteur
     *
     * @return string
     */
    public function getEmetteur()
    {
        return $this->emetteur;
    }

    /**
     * Set recepteur
     *
     * @param string $recepteur
     *
     * @return Courrier
     */
    public function setRecepteur($recepteur)
    {
        $this->recepteur = $recepteur;

        return $this;
    }

    /**
     * Get recepteur
     *
     * @return string
     */
    public function getRecepteur()
    {
        return $this->recepteur;
    }

    /**
     * Set image
     *
     * @param \AppBundle\Entity\Image $image
     *
     * @return Courrier
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
     * @return Courrier
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
     * Set antenne
     *
     * @param \AppBundle\Entity\Antenne $antenne
     *
     * @return Courrier
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Courrier
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
     * Set file
     *
     * @param \AppBundle\Entity\File $file
     *
     * @return Article
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
