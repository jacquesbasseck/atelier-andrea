<?php

namespace Atelier\AndreaBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Competence
 *
 * @ORM\Table(name="competence")
 * @ORM\Entity(repositoryClass="Atelier\AndreaBundle\Repository\CompetenceRepository")
 */
class Competence
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
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Atelier\AndreaBundle\Entity\Collaborateur", inversedBy="competences")
     */
    private $collaborateurs;

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
     * Set titre
     *
     * @param string $titre
     *
     * @return Competence
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Competence
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
     * Constructor
     */
    public function __construct()
    {
        $this->collaborateurs = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add collaborateur
     *
     * @param \Atelier\AndreaBundle\Entity\Collaborateur $collaborateur
     *
     * @return Competence
     */
    public function addCollaborateur(\Atelier\AndreaBundle\Entity\Collaborateur $collaborateur)
    {
        $this->collaborateurs[] = $collaborateur;

        return $this;
    }

    /**
     * Remove collaborateur
     *
     * @param \Atelier\AndreaBundle\Entity\Collaborateur $collaborateur
     */
    public function removeCollaborateur(\Atelier\AndreaBundle\Entity\Collaborateur $collaborateur)
    {
        $this->collaborateurs->removeElement($collaborateur);
    }

    /**
     * Get collaborateurs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCollaborateurs()
    {
        return $this->collaborateurs;
    }
}
