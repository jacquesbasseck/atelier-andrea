<?php

namespace Atelier\AndreaBundle\Entity;

use Atelier\AndreaBundle\Entity\Collaborateur;
use Atelier\AndreaBundle\Entity\RendezVous;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Soin
 *
 * @ORM\Table(name="soin")
 * @ORM\Entity(repositoryClass="Atelier\AndreaBundle\Repository\SoinRepository")
 */
class Soin
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
     * @ORM\Column(name="couleur", type="string", length=12, nullable=false, options={"default"="blue"})
     */
    private $couleur;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="duree", type="integer")
     */
    private $duree;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="Atelier\AndreaBundle\Entity\RendezVous", inversedBy="soins", cascade={"persist"})
     * @ORM\JoinTable(name="rendezvous_soin")
     */
    private $rendezVous;

    /**
     * @var Collaborateur
     *
     * @ORM\ManyToMany(targetEntity="Atelier\AndreaBundle\Entity\Collaborateur", inversedBy="soins")
     */
    private $collaborateur;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        $this->rendezVous = new ArrayCollection();
        return $this->id;
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
     * Set nom
     *
     * @param string $nom
     *
     * @return Soin
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Soin
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get duree
     *
     * @return int
     */
    public function getDuree()
    {
        return $this->duree;
    }

    /**
     * Set duree
     *
     * @param integer $duree
     *
     * @return Soin
     */
    public function setDuree($duree)
    {
        $this->duree = $duree;

        return $this;
    }

    /**
     * Set rendezVous
     *
     * @param RendezVous $rendezVous
     *
     * @return Soin
     */
    public function setRendezVous(RendezVous $rendezVous = null)
    {
        $this->rendezVous = $rendezVous;

        return $this;
    }

    /**
     * Get rendezVous
     *
     * @return ArrayCollection
     */
    public function getRendezVous()
    {
        return $this->rendezVous;
    }

    /**
     * Set collaborateur
     *
     * @param Collaborateur $collaborateur
     *
     * @return Soin
     */
    public function setCollaborateur(Collaborateur $collaborateur = null)
    {
        $this->collaborateur = $collaborateur;

        return $this;
    }

    /**
     * Get collaborateur
     *
     * @return Collaborateur
     */
    public function getCollaborateur()
    {
        return $this->collaborateur;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->rendezVous = new ArrayCollection();
        $this->collaborateur = new ArrayCollection();
    }

    /**
     * Add rendezVous
     *
     * @param \Atelier\AndreaBundle\Entity\RendezVous $rendezVous
     *
     * @return Soin
     */
    public function addRendezVous(RendezVous $rendezVous)
    {
        $this->rendezVous[] = $rendezVous;

        return $this;
    }

    /**
     * Remove rendezVous
     *
     * @param \Atelier\AndreaBundle\Entity\RendezVous $rendezVous
     */
    public function removeRendezVous(RendezVous $rendezVous)
    {
        $this->rendezVous->removeElement($rendezVous);
    }

    /**
     * Add collaborateur
     *
     * @param \Atelier\AndreaBundle\Entity\Collaborateur $collaborateur
     *
     * @return Soin
     */
    public function addCollaborateur(\Atelier\AndreaBundle\Entity\Collaborateur $collaborateur)
    {
        $this->collaborateur[] = $collaborateur;

        return $this;
    }

    /**
     * Remove collaborateur
     *
     * @param \Atelier\AndreaBundle\Entity\Collaborateur $collaborateur
     */
    public function removeCollaborateur(\Atelier\AndreaBundle\Entity\Collaborateur $collaborateur)
    {
        $this->collaborateur->removeElement($collaborateur);
    }

    /**
     * Set couleur
     *
     * @param string $couleur
     *
     * @return Soin
     */
    public function setCouleur($couleur)
    {
        $this->couleur = $couleur;

        return $this;
    }

    /**
     * Get couleur
     *
     * @return string
     */
    public function getCouleur()
    {
        return $this->couleur;
    }
}
