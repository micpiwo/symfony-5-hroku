<?php

namespace App\Entity;

use App\Repository\DistributeurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DistributeurRepository::class)
 */
class Distributeur
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany (targetEntity="App\Entity\Produits", mappedBy="distributeurs")
     * @ORM\JoinColumn (nullable=true)
     */
    private $produit;

    /**
     * @return mixed
     */
    public function getProduit()
    {
        return $this->produit;
    }

    /**
     * @param mixed $produit
     */
    public function setProduit($produit): void
    {
        $this->produit = $produit;
    }

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomDistributeur;

    public function __construct()
    {
        $this->produit = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomDistributeur(): ?string
    {
        return $this->nomDistributeur;
    }

    public function setNomDistributeur(string $nomDistributeur): self
    {
        $this->nomDistributeur = $nomDistributeur;

        return $this;
    }

    public function addProduit(Produits $produit): self
    {
        if (!$this->produit->contains($produit)) {
            $this->produit[] = $produit;
            $produit->addDistributeur($this);
        }

        return $this;
    }

    public function removeProduit(Produits $produit): self
    {
        if ($this->produit->removeElement($produit)) {
            $produit->removeDistributeur($this);
        }

        return $this;
    }
}
