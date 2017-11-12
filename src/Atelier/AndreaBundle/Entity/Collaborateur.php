<?php

namespace Atelier\AndreaBundle\Entity;

use Atelier\AndreaBundle\Traits\DoctrineExtension;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use User\UserBundle\Entity\User;

/**
 * Collaborateur
 *
 * @ORM\Table(name="collaborateur")
 * @ORM\Entity(repositoryClass="Atelier\AndreaBundle\Repository\CollaborateurRepository")
 */
class Collaborateur extends User
{
    use DoctrineExtension;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var bool
     *
     * @ORM\Column(name="present", type="boolean")
     */
    private $present;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="Atelier\AndreaBundle\Entity\Soin", mappedBy="collaborateur")
     * @ORM\JoinTable(name="collaborateur_soin")
     */
    private $soins;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="Atelier\AndreaBundle\Entity\Competence", mappedBy="collaborateurs")
     * @ORM\JoinTable(name="collaborateur_competence")
     */
    private $competences;

    /**
     * @var User
     * @ORM\OneToOne(targetEntity="User\UserBundle\Entity\User", inversedBy="collaborateur")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function __construct()
    {
        parent::__construct ();

        $this->soins = new ArrayCollection();
        $this->competences = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get present
     *
     * @return bool
     */
    public function getPresent()
    {
        return $this->present;
    }

    /**
     * Set present
     *
     * @param boolean $present
     *
     * @return Collaborateur
     */
    public function setPresent($present)
    {
        $this->present = $present;

        return $this;
    }

    /**
     * Add soin
     *
     * @param Soin $soin
     *
     * @return Collaborateur
     */
    public function addSoin(Soin $soin)
    {
        $this->soins[] = $soin;

        return $this;
    }

    /**
     * Remove soin
     *
     * @param Soin $soin
     */
    public function removeSoin(Soin $soin)
    {
        $this->soins->removeElement ( $soin );
    }

    /**
     * Get soins
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSoins()
    {
        return $this->soins;
    }

    /**
     * Add competence
     *
     * @param Competence $competence
     *
     * @return Collaborateur
     */
    public function addCompetence(Competence $competence)
    {
        $this->competences[] = $competence;

        return $this;
    }

    /**
     * Remove competence
     *
     * @param Competence $competence
     */
    public function removeCompetence(Competence $competence)
    {
        $this->competences->removeElement ( $competence );
    }

    /**
     * Get competences
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCompetences()
    {
        return $this->competences;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Collaborateur
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Collaborateur
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get user
     *
     * @return \User\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set user
     *
     * @param \User\UserBundle\Entity\User $user
     *
     * @return Collaborateur
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Add adress
     *
     * @param Adresse $adress
     *
     * @return Collaborateur
     */
    public function addAdress(Adresse $adress)
    {
        $this->adresses[] = $adress;

        return $this;
    }

    /**
     * Remove adress
     *
     * @param Adresse $adress
     */
    public function removeAdress(Adresse $adress)
    {
        $this->adresses->removeElement ( $adress );
    }
}
