<?php

namespace Atelier\AndreaBundle\Entity;

use Atelier\AndreaBundle\Traits\DoctrineExtension;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Tarif
 *
 * @ORM\Table(name="tarif")
 * @ORM\Entity(repositoryClass="Atelier\AndreaBundle\Repository\TarifRepository")
 */
class Tarif
{
    use DoctrineExtension;

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
     * @var float
     *
     * @ORM\Column(name="prix", type="float")
     */
    private $prix;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="Atelier\AndreaBundle\Entity\Produit", mappedBy="tarifs")
     */
    private $produits;

    /**
     * @var Tva
     * @ORM\ManyToOne(targetEntity="Atelier\AndreaBundle\Entity\Tva")
     * @ORM\JoinColumn(nullable=true)
     *
     */
    private $tva;

    public function __construct()
    {
        $this->produits = new ArrayCollection();
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
     * Set nom
     *
     * @param string $nom
     *
     * @return Tarif
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
     * Set prix
     *
     * @param float $prix
     *
     * @return Tarif
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return float
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Add produit
     *
     * @param \Atelier\AndreaBundle\Entity\Produit $produit
     *
     * @return Tarif
     */
    public function addProduit(\Atelier\AndreaBundle\Entity\Produit $produit)
    {
        $this->produits[] = $produit;

        return $this;
    }

    /**
     * Remove produit
     *
     * @param \Atelier\AndreaBundle\Entity\Produit $produit
     */
    public function removeProduit(\Atelier\AndreaBundle\Entity\Produit $produit)
    {
        $this->produits->removeElement($produit);
    }

    /**
     * Get produits
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProduits()
    {
        return $this->produits;
    }

    /**
     * Set tva
     *
     * @param \Atelier\AndreaBundle\Entity\Tva $tva
     *
     * @return Tarif
     */
    public function setTva(\Atelier\AndreaBundle\Entity\Tva $tva = null)
    {
        $this->tva = $tva;

        return $this;
    }

    /**
     * Get tva
     *
     * @return \Atelier\AndreaBundle\Entity\Tva
     */
    public function getTva()
    {
        return $this->tva;
    }
}
