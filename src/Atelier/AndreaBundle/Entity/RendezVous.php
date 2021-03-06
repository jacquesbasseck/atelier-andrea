<?php

namespace Atelier\AndreaBundle\Entity;

use Atelier\AndreaBundle\Traits\DoctrineExtension;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use User\UserBundle\Entity\User;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * RendezVous
 *
 * @ORM\Table(name="rendez_vous")
 * @ORM\Entity(repositoryClass="Atelier\AndreaBundle\Repository\RendezVousRepository")
 */
class RendezVous
{
    //
    //use DoctrineExtension;

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
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="debut", type="datetimetz")
     */
    private $debut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fin", type="datetimetz")
     */
    private $fin;

    /**
     * @var string
     *
     * @ORM\Column(name="infos", type="text", nullable=true)
     */
    private $infos;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User\UserBundle\Entity\User", inversedBy="rendezVous")
     */
    private $user;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="Atelier\AndreaBundle\Entity\Soin", mappedBy="rendezVous", cascade={"persist"}, fetch="LAZY")
     */
    private $soins;

    public function __construct()
    {
        $this->soins = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * @param string $titre
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
    }

    /**
     * Get id
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get debut
     * @return \DateTime
     */
    public function getDebut()
    {
        return $this->debut;
    }

    /**
     * Set debut
     *
     * @param \DateTime $debut
     * @return RendezVous
     */
    public function setDebut($debut)
    {
        $this->debut = $debut;

        return $this;
    }

    /**
     * Get fin
     * @return \DateTime
     */
    public function getFin()
    {
        return $this->fin;
    }

    /**
     * Set fin
     *
     * @param \DateTime $fin
     * @return RendezVous
     */
    public function setFin($fin)
    {
        $this->fin = $fin;

        return $this;
    }

    /**
     * Get infos
     * @return string
     */
    public function getInfos()
    {
        return $this->infos;
    }

    /**
     * Set infos
     *
     * @param string $infos
     * @return RendezVous
     */
    public function setInfos($infos)
    {
        $this->infos = $infos;

        return $this;
    }

    /**
     * Add soin
     * @param Soin $soin
     * @return RendezVous
     */
    public function addSoin(Soin $soin)
    {
        $this->soins[] = $soin;

        return $this;
    }

    /**
     * Remove soin
     * @param Soin $soin
     */
    public function removeSoin(Soin $soin)
    {
        $this->soins->removeElement ( $soin );
    }

    /**
     * Get soins
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSoins()
    {
        return $this->soins;
    }

    /**
     * Set user
     * @param \User\UserBundle\Entity\User $user
     * @return RendezVous
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     * @return \User\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
