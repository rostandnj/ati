<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Type;

/**
 * Antenne
 *
 * @ORM\Table(name="antenne")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AntenneRepository")
 * @ExclusionPolicy("none")
 */
class Antenne extends Model\JsonObject
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
     * @ORM\Column(name="Ville", type="string", length=255)
     */
    private $ville;

    /**
     * @var string
     *
     * @ORM\Column(name="pays", type="string", length=255)
     */
    private $pays;

    /**
     * @var string
     *
     * @ORM\Column(name="contact", type="string", length=255)
     */
    private $contact;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Magasin",mappedBy="antenne" )
     */
    private $magasins;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Utilisateur", mappedBy="antenne")
     */
    private $utilisateurs;

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
     * Set libelle
     *
     * @param string $libelle
     *
     * @return Antenne
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
     * Set ville
     *
     * @param string $ville
     *
     * @return Antenne
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set pays
     *
     * @param string $pays
     *
     * @return Antenne
     */
    public function setPays($pays)
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * Get pays
     *
     * @return string
     */
    public function getPays()
    {
        return $this->pays;
    }

    /**
     * Set contact
     *
     * @param string $contact
     *
     * @return Antenne
     */
    public function setContact($contact)
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * Get contact
     *
     * @return string
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Antenne
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->magasins = new \Doctrine\Common\Collections\ArrayCollection();
        $this->utilisateurs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->actif =true;
    }

    /**
     * Add magasin
     *
     * @param \AppBundle\Entity\Magasin $magasin
     *
     * @return Antenne
     */
    public function addMagasin(\AppBundle\Entity\Magasin $magasin)
    {
        $this->magasins[] = $magasin;

        return $this;
    }

    /**
     * Remove magasin
     *
     * @param \AppBundle\Entity\Magasin $magasin
     */
    public function removeMagasin(\AppBundle\Entity\Magasin $magasin)
    {
        $this->magasins->removeElement($magasin);
    }

    /**
     * Get magasins
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMagasins()
    {
        return $this->magasins;
    }

    /**
     * Add utilisateur
     *
     * @param \AppBundle\Entity\Utilisateur $utilisateur
     *
     * @return Antenne
     */
    public function addUtilisateur(\AppBundle\Entity\Utilisateur $utilisateur)
    {
        $this->utilisateurs[] = $utilisateur;

        return $this;
    }

    /**
     * Remove utilisateur
     *
     * @param \AppBundle\Entity\Utilisateur $utilisateur
     */
    public function removeUtilisateur(\AppBundle\Entity\Utilisateur $utilisateur)
    {
        $this->utilisateurs->removeElement($utilisateur);
    }

    /**
     * Get utilisateurs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUtilisateurs()
    {
        return $this->utilisateurs;
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
