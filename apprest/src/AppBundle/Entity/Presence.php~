<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Type;

/**
 * Presence
 *
 * @ORM\Table(name="presence")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PresenceRepository")
 * @ExclusionPolicy("none")
 */
class Presence extends Model\JsonObject
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="arrivee", type="string",nullable=true)
     */
    private $arrivee;

    /**
     * @var string
     *
     * @ORM\Column(name="depart", type="string",nullable=true)
     */
    private $depart;

    /**
     * @var string
     *
     * @ORM\Column(name="loginplace", type="string",nullable=true)
     */
    private $loginplace;

    /**
     * @var string
     *
     * @ORM\Column(name="loginip", type="string",nullable=true)
     */
    private $loginip;

    /**
     * @var string
     *
     * @ORM\Column(name="logoutip", type="string",nullable=true)
     */
    private $logoutip;

    /**
     * @var string
     *
     * @ORM\Column(name="logoutplace", type="string",nullable=true)
     */
    private $logoutplace;

    /**
     * @var string
     *
     * @ORM\Column(name="closeby", type="string",nullable=true)
     */
    private $closeby;


    /**
     * @var Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur", cascade={"persist", "remove"})
     */
    private $utilisateur;


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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Presence
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
     * Set utilisateur
     *
     * @param \AppBundle\Entity\Utilisateur $utilisateur
     *
     * @return Presence
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
     * Set arrivee
     *
     * @param string $arrivee
     *
     * @return Presence
     */
    public function setArrivee($arrivee)
    {
        $this->arrivee = $arrivee;

        return $this;
    }

    /**
     * Get arrivee
     *
     * @return string
     */
    public function getArrivee()
    {
        return $this->arrivee;
    }

    /**
     * Set depart
     *
     * @param string $depart
     *
     * @return Presence
     */
    public function setDepart($depart)
    {
        $this->depart = $depart;

        return $this;
    }

    /**
     * Get depart
     *
     * @return string
     */
    public function getDepart()
    {
        return $this->depart;
    }

    /**
     * Set loginplace
     *
     * @param string $loginplace
     *
     * @return Presence
     */
    public function setLoginplace($loginplace)
    {
        $this->loginplace = $loginplace;

        return $this;
    }

    /**
     * Get loginplace
     *
     * @return string
     */
    public function getLoginplace()
    {
        return $this->loginplace;
    }

    /**
     * Set logoutplace
     *
     * @param string $logoutplace
     *
     * @return Presence
     */
    public function setLogoutplace($logoutplace)
    {
        $this->logoutplace = $logoutplace;

        return $this;
    }

    /**
     * Get logoutplace
     *
     * @return string
     */
    public function getLogoutplace()
    {
        return $this->logoutplace;
    }

    /**
     * Set closeby
     *
     * @param string $closeby
     *
     * @return Presence
     */
    public function setCloseby($closeby)
    {
        $this->closeby = $closeby;

        return $this;
    }

    /**
     * Get closeby
     *
     * @return string
     */
    public function getCloseby()
    {
        return $this->closeby;
    }

    /**
     * Set loginip
     *
     * @param string $loginip
     *
     * @return Presence
     */
    public function setLoginip($loginip)
    {
        $this->loginip = $loginip;

        return $this;
    }

    /**
     * Get loginip
     *
     * @return string
     */
    public function getLoginip()
    {
        return $this->loginip;
    }

    /**
     * Set logoutip
     *
     * @param string $logoutip
     *
     * @return Presence
     */
    public function setLogoutip($logoutip)
    {
        $this->logoutip = $logoutip;

        return $this;
    }

    /**
     * Get logoutip
     *
     * @return string
     */
    public function getLogoutip()
    {
        return $this->logoutip;
    }
}
