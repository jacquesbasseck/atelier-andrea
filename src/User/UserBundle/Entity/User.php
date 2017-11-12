<?php

namespace User\UserBundle\Entity;

use Atelier\AndreaBundle\Entity\Adresse;
use Atelier\AndreaBundle\Entity\Commande;
use Atelier\AndreaBundle\Entity\RendezVous;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="User\UserBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    protected $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255)
     */
    protected $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="telephone", type="string", length=20, nullable=true)
     */
    protected $telephone;

    /**
     * @var string
     *
     * @ORM\Column(name="sexe", type="string", length=50)
     */
    protected $sexe;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_naissance", type="date", nullable=true)
     */
    private $dateNaissance;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;


    /**
     * @var string
     *
     * @ORM\Column(name="profession", type="string", length=255, nullable=true)
     */
    protected $profession;

    /**
     * @var int
     *
     * @ORM\Column(name="point", type="integer", options={"default": 0})
     * @ORM\Column()
     */
    protected $point;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Atelier\AndreaBundle\Entity\Adresse", mappedBy="user", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    protected $adresses;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Atelier\AndreaBundle\Entity\RendezVous", mappedBy="user", cascade={"remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    protected $rendezVous;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Atelier\AndreaBundle\Entity\Commande", mappedBy="user", cascade={"remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    protected $commandes;

    /**
     * @var User
     * @ORM\OneToOne(targetEntity="Atelier\AndreaBundle\Entity\Collaborateur", mappedBy="user")
     * @ORM\JoinColumn(nullable=true)
     */
    private $collaborateur;

    public function __construct()
    {
        parent::__construct ();

        $this->rendezVous = new ArrayCollection();
        $this->adresses = new ArrayCollection();
        $this->commandes = new ArrayCollection();
        $this->point = 0;
    }



    public function getId()
    {
        return $this->id;
    }


    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return User
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
     * Set prenom
     *
     * @param string $prenom
     *
     * @return User
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set telephone
     *
     * @param string $telephone
     *
     * @return User
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get telephone
     *
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set sexe
     *
     * @param string $sexe
     *
     * @return User
     */
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;

        return $this;
    }

    /**
     * Get sexe
     *
     * @return string
     */
    public function getSexe()
    {
        return $this->sexe;
    }

    /**
     * Set dateNaissance
     *
     * @param \DateTime $dateNaissance
     *
     * @return User
     */
    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    /**
     * Get dateNaissance
     *
     * @return \DateTime
     */
    public function getDateNaissance()
    {
        return $this->dateNaissance;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return User
     */
    public function setDescription($description)
    {
        $this->description = $description;

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
     * Set profession
     *
     * @param string $profession
     *
     * @return User
     */
    public function setProfession($profession)
    {
        $this->profession = $profession;

        return $this;
    }

    /**
     * Get profession
     *
     * @return string
     */
    public function getProfession()
    {
        return $this->profession;
    }

    /**
     * Set point
     *
     * @param integer $point
     *
     * @return User
     */
    public function setPoint($point)
    {
        $this->point = $point;

        return $this;
    }

    /**
     * Get point
     *
     * @return integer
     */
    public function getPoint()
    {
        return $this->point;
    }

    /**
     * Add adresse
     *
     * @param Adresse $adresse
     *
     * @return User
     */
    public function addAdresse(Adresse $adresse)
    {
        $this->adresses[] = $adresse;

        return $this;
    }

    /**
     * Remove adresse
     *
     * @param Adresse $adresse
     */
    public function removeAdresse(Adresse $adresse)
    {
        $this->adresses->removeElement($adresse);
    }

    /**
     * Get adresses
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAdresses()
    {
        return $this->adresses;
    }

    /**
     * Add rendezVous
     *
     * @param RendezVous $rendezVous
     *
     * @return User
     */
    public function addRendezVous(RendezVous $rendezVous)
    {
        $this->rendezVous[] = $rendezVous;

        return $this;
    }

    /**
     * Remove rendezVous
     *
     * @param RendezVous $rendezVous
     */
    public function removeRendezVous(RendezVous $rendezVous)
    {
        $this->rendezVous->removeElement($rendezVous);
    }

    /**
     * Get rendezVous
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRendezVous()
    {
        return $this->rendezVous;
    }

    /**
     * Add commande
     *
     * @param Commande $commande
     *
     * @return User
     */
    public function addCommande(Commande $commande)
    {
        $this->commandes[] = $commande;

        return $this;
    }

    /**
     * Remove commande
     *
     * @param Commande $commande
     */
    public function removeCommande(Commande $commande)
    {
        $this->commandes->removeElement($commande);
    }

    /**
     * Get commandes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCommandes()
    {
        return $this->commandes;
    }

    /**
     * Add adress
     *
     * @param \Atelier\AndreaBundle\Entity\Adresse $adress
     *
     * @return User
     */
    public function addAdress(\Atelier\AndreaBundle\Entity\Adresse $adress)
    {
        $this->adresses[] = $adress;

        return $this;
    }

    /**
     * Remove adress
     *
     * @param \Atelier\AndreaBundle\Entity\Adresse $adress
     */
    public function removeAdress(\Atelier\AndreaBundle\Entity\Adresse $adress)
    {
        $this->adresses->removeElement($adress);
    }

    /**
     * Set collaborateur
     *
     * @param \Atelier\AndreaBundle\Entity\Collaborateur $collaborateur
     *
     * @return User
     */
    public function setCollaborateur(\Atelier\AndreaBundle\Entity\Collaborateur $collaborateur)
    {
        $this->collaborateur = $collaborateur;

        return $this;
    }

    /**
     * Get collaborateur
     *
     * @return \Atelier\AndreaBundle\Entity\Collaborateur
     */
    public function getCollaborateur()
    {
        return $this->collaborateur;
    }
}
